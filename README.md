# CivertCodeAssessment

Usage is like -

```bash
#For simple pings to get site title + status code

symfony console check:alive http://google.com

#To check the status code against expected

symfony console check:alive http://google.com --status=200
symfony console check:alive http://google.com -s=200

#To check the site title against expected

symfony console check:alive http://google.com --title=Google
symfony console check:alive http://google.com -t=Google

#To check both site title against expected
symfony console check:alive http://google.com --title=Google --status=200
symfony console check:alive http://google.com -t=Google -s=201
```

Configuration is set to notify the terminal regardless of match or no match. Only notify by SMS and Email on non-matching results.
