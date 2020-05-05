# Differences between old `mysql_*` API and mysqli class 
The primary reason for the new extension was to add support for prepared statements to PHP. MySQL has added support for native prepared statements in version 4.1.3 and it was only logical to deprecate the old `mysql_*` functions in order to teach PHP developers about the new proper way of executing MySQL statements. Adding the prepared statement support was a very high priotity if PHP was to ever improve as a language. 

Another very important factor was error reporting. PHP was moving towards error exceptions and it made perfect sense to add automatic error reporting to mysqli. However, the developers of this extension decided it would be too risky to set the default setting to on due to all the SQL injection vulnerabilities out there. The default setting is off, but using one line of code you can enable error reporting as exceptions. The only excpetion to this is `new mysqli`/`mysqli_connect()` which throws warnings even when error reporting is switched off. 

To encourage PHP developers to make the switch function aliases were created for the class methods. These are clunky and confusing and it is always better to use OOP style. Notable exceptions to this is only `mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);` which is simpler using function syntax. 

# What needs to be done when refactoring your code to mysqli?
The first and foremost thing is switching to parameterized prepared statements. Only SQL queries with dynamic variables need to be parameterized, but it does not harm to use prepared statement all the time. This means you can completely forget about `mysql_query()`. Use the pattern `prepare/bind_param/execute/get_result` instead. The only proper is that prior to mysqlnd there was no easy way of fetching results from prepared statement. Mostly for this reason it is recommended to avoid using mysqli class on its own in the code. It's much better to create an abstraction class, which will take care of these difference and provide the data in PHP arrays. 

The second thing is to switch on error reporting. Say "good riddance" to the terrible practice of `die(mysql_error())`. No more cryptic error messages. From now on you will get proper exceptions with full call stack, which obey PHP's error_reporting and display_errors settings. 

Next thing is to identify deprecated functions, which do not have a trivial replacement in mysqli class. There's plenty of such functions. 

- mysql_create_db
- mysql_createdb
- mysql_drop_db
- mysql_dropdb
- mysql_db_name 
- mysql_dbname
- mysql_list_dbs 
- mysql_listdbs
- mysql_list_tables 
- mysql_listtables
- mysql_list_fields 
- mysql_listfields
- mysql_db_query 
- mysql_list_processes 
- mysql_result 
- mysql_tablename 
- mysql_unbuffered_query 
- and more...

`mysql_fetch_field()` and `mysql_field_*` functions have a workaround in mysqli, but it works completely different. 

# Why mysqli?
I ask myself the same question. The upgrade process from `mysql_*` functions to mysqli requires a complete rewrite of the old project. Mysqli class was barely functional when first released. It still suffers from a lot of bad decisions and plenty of known bugs (some can generate segmentation faults and are marked as Won't fix by PHP team). I assume the idea was to provide an intermediate shim for users on their upgrade path to PHP 5 who were familiar with the old function names. Mysqli's methods were designed to be familiar to those users and still teach the new concepts such as prepared statements. However, the fact that until PHP 5.3 this extension was almost unusuable didn't help. 

**PHP offers a much better and more mature extension called PDO. If you are starting a new project or if you need to upgrade an existing PHP 4 project, you should use PDO. One way or the other you need to rewrite your code, so why not choose the easier and better option.**

# Can you employ an automated tool to refactor your old PHP code to use mysqli extension? 
In theory yes, but creating such a tool is going to be a very big effort for something that still needs manual code changes. 

The most naive solution is to simply add a letter `i` in the name. However, **this will not solve all your problems and if this is the only change you make to your code then why not keep using the old deprecated API?** 

Another approach would be to use static analysis to figure out what the code does and if it could be automatically rewritten to use mysqli class. In theory this is possible, but every change still needs to be manually checked and possibly it could create more work than if done by hand. 

PHP 4 suffered from a lot of bad practices and hacks, which were solved with the addition of new features in PHP 5 and in PHP 7. With the advent of PHP 8 it could be more practical to simply start a new project rather than trying to solve the old one by applying stupid patches. If you can't afford to rewrite the old project then there's no point in upgrading your PHP version. You must take advantage of the improvements in recent PHP version to improve the reliability and security of your application. 

I have seen examples on Stack Overflow where some 10 LOC hack or workaround could be replaced with one line of code. Autoloader and type hinting are things which you can live about but they do make your life ten times easier. I could keep listing new PHP features which made PHP great, but the conclusion is that if you have an old PHP project, first you need to change your way of thinking and learn new PHP and then completely rewrite your exiting software from grounds up. 

# What's in this Git?
This Git contains some examples of what the code using `mysql_*` API looked like and what would be the expected code using mysqli. The examples are simple and are all missing one crucial step which I have not talked about. `set_charset()`. It is one line of code that is extremely important. Without it you are risking data corruption and SQL injection. The recommeneded charset for MySQL and MariaDB is `utf8mb4`. 

It contains rector as a dependancy to demostrate that this tool does not fix any of these examples taken from php.net.
