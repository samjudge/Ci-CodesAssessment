<?php

namespace App\Command;

use App\NotificationWriters\Interfaces\Notifier;
use App\NotificationWriters\Models\TitleStatusPairNotification;
use App\TitleStatusPairs\Models\Pair;
use App\TitleStatusPairs\Parser\ResponseParser;
use App\TitleStatusPairs\Validator\Validator;
use Fig\Http\Message\RequestMethodInterface;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckAlive extends Command
{
    protected static $defaultName = "check:alive";

    const ARGV_ADDRESS = 'address';
    const OPT_TITLE = 'title';
    const OPT_TITLE_SHORT = 't';
    const OPT_STATUS = 'status';
    const OPT_STATUS_SHORT = 's';

    private HttpClientInterface $httpClient;
    private Validator $validator;
    private Notifier $notifier;
    private ResponseParser $responseParser;

    public function __construct(
        HttpClientInterface $httpClient,
        Validator $validator,
        Notifier $notifier,
        ResponseParser $responseParser
    ) {
        parent::__construct();
        $this->httpClient = $httpClient;
        $this->validator = $validator;
        $this->notifier = $notifier;
        $this->responseParser = $responseParser;
    }

    protected function configure() {
        $this->addArgument(self::ARGV_ADDRESS)
             ->addOption(self::OPT_TITLE, self::OPT_TITLE_SHORT, InputOption::VALUE_OPTIONAL)
             ->addOption(self::OPT_STATUS, self::OPT_STATUS_SHORT, InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $expectedResults = new Pair(
            $input->getOption(self::OPT_TITLE),
            $input->getOption(self::OPT_STATUS)
        );
        $response = $this->httpClient->request(     // There's a lot of uncaught exceptions throughout this application, I'm aware just didn't want to
            RequestMethodInterface::METHOD_GET,     // get bogged down with them since the traces are generally quite pretty w/ the symfony-cli as is.
            $input->getArgument(self::ARGV_ADDRESS) // But if this was something which was as i.e. a cron or other scheduled task it would not be appropriate.
        );
        $actualResults = $this->responseParser->parse($response);
        $validationResult = $this->validator->validate(
            $expectedResults,
            $actualResults
        );
        $this->notifier->notify(
            new TitleStatusPairNotification(
                $input->getArgument(self::ARGV_ADDRESS),
                $expectedResults,
                $actualResults,
                $validationResult
            )
        );
        return self::SUCCESS;
    }



}