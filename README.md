
# Ruby (Sinatra) vs PHP (Limonade) Memory Usage comparison


# UPDATE (2010-03-27)

Thanks to [binary42](http://github.com/binary42/) who pm'd me with some notes about using `ps ...` being expensive, I did
the benchmarking tests again with the memory usage checks turned off in both apps, and got widely different results:

    ab -n 2000 -c 20 http://__URL__/


Ruby/Sinatra/Apache/Passenger: **603 requests/sec**

PHP/Limonade/Apache: **323.85 requests/sec**

but the big winner is:

Ruby/Sinatra/Thin(1.2.7): **1747.20** requests/sec or **1987.36** requests/sec (in production mode)

--------

## IMPORTANT ! PLEASE TAKE NOTE !  

This is in **no way** intended as a pro / against either Ruby or PHP. 

**SO PLEASE DON'T USE IT AS SUCH!** Thanks


-----

### Background:

I **prefer to code in Ruby / Sinatra**, and would ideally not use any other language, but sometimes reality sets in, and I have to do some website work in PHP.

While converting a fairly simple Sinatra app into PHP I realised that the memory usage was widely different.

I have therefore tried to create two almost identical simple applications in Ruby's [Sinatra](http://github.com/sinatra/sinatra) framework and in PHP's [Limonade](http://github.com/sofadesign/limonade) framework.

When running both of these apps on my Mac OS X 10.6 - system, I get these results:

* Ruby (1.8.7 p72) / Sinatra (1.0) / Apache 2 (Phusion Passenger (mod_rails/mod_rack) 2.2.11 )

### IN PRODUCTION MODE

#### Startup Memory Usage:  **19.76 MB**


    [~]$ ab -n 100 -c 10 http://sinatra-app.local/

    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
    Licensed to The Apache Software Foundation, http://www.apache.org/

    Benchmarking sinatra-app.local (be patient).....done

    Server Software:        Apache/2.2.13
    Server Hostname:        sinatra-app.local
    Server Port:            80

    Document Path:          /
    Document Length:        1585 bytes

    Concurrency Level:      10
    Time taken for tests:   1.514 seconds
    Complete requests:      100
    Failed requests:        0
    Write errors:           0
    Total transferred:      188200 bytes
    HTML transferred:       158500 bytes
    Requests per second:    66.06 [#/sec] (mean)
    Time per request:       151.379 [ms] (mean)
    Time per request:       15.138 [ms] (mean, across all concurrent requests)
    Transfer rate:          121.41 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    0   0.2      0       1
    Processing:    32  150 222.0     44     765
    Waiting:       32  149 222.0     43     764
    Total:         32  150 222.0     44     765

    Percentage of the requests served within a certain time (ms)
      50%     44
      66%     52
      75%     67
      80%    384
      90%    417
      95%    750
      98%    764
      99%    765
     100%    765 (longest request)
    [~]$ 



### IN DEVELOPMENT MODE

#### Startup Memory Usage:  **19.25 MB**   
#### End of Run Memory Usage:  **30.23 MB**



    [~]$ ab -n 100 -c 10 http://sinatra-app.local/
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
    Licensed to The Apache Software Foundation, http://www.apache.org/

    Benchmarking sinatra-app.local (be patient).....done


    Server Software:        Apache/2.2.13
    Server Hostname:        sinatra-app.local
    Server Port:            80

    Document Path:          /
    Document Length:        1585 bytes

    Concurrency Level:      10
    Time taken for tests:   1.491 seconds
    Complete requests:      100
    Failed requests:        0
    Write errors:           0
    Total transferred:      188200 bytes
    HTML transferred:       158500 bytes
    Requests per second:    67.08 [#/sec] (mean)
    Time per request:       149.084 [ms] (mean)
    Time per request:       14.908 [ms] (mean, across all concurrent requests)
    Transfer rate:          123.28 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    0   0.3      0       3
    Processing:    49  146 151.2     74     478
    Waiting:       48  146 151.2     74     478
    Total:         49  147 151.1     74     478

    Percentage of the requests served within a certain time (ms)
      50%     74
      66%     92
      75%    119
      80%    410
      90%    443
      95%    458
      98%    470
      99%    478
     100%    478 (longest request)
    [~]$





* PHP (5.3.0) / Limonade (edge) / Apache 2 (Phusion Passenger (mod_rails/mod_rack) 2.2.11 )

#### Startup Memory Usage:  **1.25 MB**


    [~]$ ab -n 100 -c 10 http://php-app.local/
    This is ApacheBench, Version 2.3 <$Revision: 655654 $>
    Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
    Licensed to The Apache Software Foundation, http://www.apache.org/

    Benchmarking php-app.local (be patient).....done


    Server Software:        Apache/2.2.13
    Server Hostname:        php-app.local
    Server Port:            80

    Document Path:          /
    Document Length:        1638 bytes

    Concurrency Level:      10
    Time taken for tests:   0.401 seconds
    Complete requests:      100
    Failed requests:        0
    Write errors:           0
    Total transferred:      211500 bytes
    HTML transferred:       163800 bytes
    Requests per second:    249.28 [#/sec] (mean)
    Time per request:       40.116 [ms] (mean)
    Time per request:       4.012 [ms] (mean, across all concurrent requests)
    Transfer rate:          514.86 [Kbytes/sec] received

    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    0   0.8      0       5
    Processing:    14   38  13.5     34      80
    Waiting:       14   38  13.5     34      80
    Total:         15   39  13.4     35      81

    Percentage of the requests served within a certain time (ms)
      50%     35
      66%     42
      75%     46
      80%     49
      90%     61
      95%     64
      98%     76
      99%     81
     100%     81 (longest request)
    [~]$ 





### Why did I do this ?


The reason behind this is to hopefully find the answer to these two simple questions:


# 1.  WHY IS THE MEMORY USAGE SEEMINGLY SO MUCH HIGHER IN THE Ruby (Sinatra) APP THAN IN THE PHP (Limonade) APP ??

# <del>2.  WHY IS THE PHP (Limonade) APP 3.77 x FASTER THAN THE Ruby (Sinatra) APP ??</del> ANSWERED

**Answer:**  slowness in Ruby/Sinatra app was **due to expensive shell-ing out action**, once removed **the Ruby/Sinatra app is almost twice as fast as the PHP app**. See update notes at top of page.


If you know the answers to these questions, or could explain things for me please do so!

### Final words.

Please do NOT use this as amunition in some infantile "PHP rocks, Ruby sucks" kind of stuff. It was created to gain a better understanding of the two programming languages and environments.





