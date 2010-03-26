

# begin
#   # Try to require the preresolved locked set of gems.
#   require File.expand_path('../.bundle/environment', __FILE__)
# rescue LoadError
#   # Fall back on doing an unlocked resolve at runtime.
#   require "rubygems"
#   require "bundler"
#   Bundler.setup
# end


require 'rubygems'
require 'sinatra/base'


class MyApp < Sinatra::Base 
  
  # set :root, File.expand_path(File.dirname(__FILE__))
  # set :root, ::APP_ROOT
  set :app_file, __FILE__
  set :public, "#{::APP_ROOT}/public"
  set :views, "#{::APP_ROOT}/views"
  
  helpers do
    def show_memory_usage
      memory_usage = `ps -o rss= -p #{Process.pid}`.to_i # in kilobytes 
      sprintf("%2.2f MB", (Float(memory_usage)/Float(1024)))
    end
  end
  
  get '/' do 
    erb(:index)
  end
  
end #/class MyApp
