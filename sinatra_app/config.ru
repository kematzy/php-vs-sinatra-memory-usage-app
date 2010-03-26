
# set the root of the whole app
APP_ROOT = Dir.pwd

puts "\n-- BootUp started \n-- APP_ROOT set to [ #{APP_ROOT} ]"

ENV['RACK_ENV'] = 'development' if ENV['RACK_ENV'].empty?

### Make sure my own gem path is included first
if (ENV['HOME'] =~ /^\/home\//)  ## DREAMHOST
  ENV['GEM_HOME'] = "#{ENV['HOME']}/.gems"
  ENV['GEM_PATH'] = "#{ENV['HOME']}/.gems:"
  require 'rubygems'
  Gem.clear_paths
end

## LOAD THE APPs
require "memoryapp"

map "/" do 
   run MyApp
end

### CALCULATE MEMORY USAGE ON BOOTUP
memory_usage = `ps -o rss= -p #{Process.pid}`.to_i # in kilobytes 
puts "-- MEMORY USAGE: #{sprintf("%2.2f MB", (Float(memory_usage)/Float(1024)))}"
puts "-- BootUp finished  \n\n"

#/EOF
