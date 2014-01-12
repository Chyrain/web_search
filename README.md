web_search
==========
[Info]
This project is a simple web Search Engine, use Coreseek(sphinx+mmseg) and a simple spider designed by python, and web API of PHP.

[web_spider]
A simple web spider,use python.

[Coreseek]
Sphinx(Its Chinese version with mmseg is named Coreseek) is a full-text search engine, distributed under GPL version 2. Commercial licensing (eg. for embedded use) is also available upon request.

Generally, it's a standalone search engine, meant to provide fast, size-efficient and relevant full-text search functions to other applications. Sphinx was specially designed to integrate well with SQL databases and scripting languages.

Currently built-in data source drivers support fetching data either via direct connection to MySQL, or PostgreSQL, or from a pipe in a custom XML format. Adding new drivers (eg. to natively support some other DBMSes) is designed to be as easy as possible.

Search API is natively ported to PHP, Python, Perl, Ruby, Java, and also available as a pluggable MySQL storage engine. API is very lightweight so porting it to new language is known to take a few hours.

As for the name, Sphinx is an acronym which is officially decoded as SQL Phrase Index. 

[index.php | sphinx.php | timer.php | sphinxapi.php]
The main directory has these PHP files: index.php | sphinx.php | timer.php | sphinxapi.php.
index.php | sphinx.php | timer.php : is my search page.
sphinxapi.php : is an API for PHP of Sphinx.


