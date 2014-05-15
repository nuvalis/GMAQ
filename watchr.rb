watch("app/src/(.*).php") do |match|
  run_test %{test/#{match[1]}Test.php}
end

watch("test/.*Test.php") do |match|
  run_test match[0]
end

def clear_console
  puts "\e[H\e[2J"  #clear console
end

def run_test(file)
	clear_console
  puts "Running #{file}"
  result = `phpunit --bootstrap test/config.php #{file}`
  puts result
  
end

