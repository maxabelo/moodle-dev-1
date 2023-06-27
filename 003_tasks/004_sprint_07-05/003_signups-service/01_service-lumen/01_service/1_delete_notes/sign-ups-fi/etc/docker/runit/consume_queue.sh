#!/bin/bash
# Name: consume_queue.sh
# Purpose: Queue Consumer with a startup delay
# ----------------------------------------------
time_sleep=1
echo "$(date '+%Y-%m-%d %H:%M:%S') INFO pending: Waiting 1 sec to start queue consumer..."
   sleep $time_sleep
   php /app/artisan queue:consume --message-limit=100 --time-limit=10 --memory-limit=50
   sleep $time_sleep
echo "$(date '+%Y-%m-%d %H:%M:%S') INFO: end queue consumer"
