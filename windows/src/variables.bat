@echo off

REM Variables for RunHiddenConsole
set "url_RunHiddenConsole=https://github.com/wenshui2008/RunHiddenConsole/releases/download/1.0/RunHiddenConsole.zip"
for %%I in ("%url_RunHiddenConsole%") do set "filename_RunHiddenConsole=%%~nxI"
set "RunHiddenConsole_folder=%filename_RunHiddenConsole:~0,-4%"

REM Variables for Node.js
set "url_NodeJS=https://nodejs.org/dist/v20.11.1/node-v20.11.1-win-x64.zip"
for %%I in ("%url_NodeJS%") do set "filename_NodeJS=%%~nxI"
set "node_folder=%filename_NodeJS:~0,-4%"
for /f "tokens=2 delims=-" %%v in ("%filename_NodeJS%") do set "version_NodeJS=%%v"

REM Variables for PHP
set "url_PHP=https://windows.php.net/downloads/releases/php-8.1.28-Win32-vs16-x64.zip"
for %%I in ("%url_PHP%") do set "filename_PHP=%%~nxI"
set "php_folder=%filename_PHP:~0,-4%"
for /f "tokens=2 delims=-" %%v in ("%filename_PHP%") do set "version_PHP=%%v"

REM Variables for PHP archive
set "url_PHP_Archive=https://windows.php.net/downloads/releases/archives/php-8.1.28-Win32-vs16-x64.zip"
for %%I in ("%url_PHP%") do set "filename_PHP_Archive=%%~nxI"
set "php_folder_Archive=%filename_PHP_Archive:~0,-4%"
for /f "tokens=2 delims=-" %%v in ("%filename_PHP_Archive%") do set "version_PHP_Archive=%%v"

REM Variables for Nginx
set "url_Nginx=https://nginx.org/download/nginx-1.24.0.zip"
for %%I in ("%url_Nginx%") do set "filename_Nginx=%%~nxI"
set "nginx_folder=%filename_Nginx:~0,-4%"
for /f "tokens=2 delims=-" %%v in ("%filename_Nginx%") do set "version_Nginx=%%v"

REM Variables for Python 3.10.12
set "url_Python=https://www.python.org/ftp/python/3.10.11/python-3.10.11-embed-amd64.zip"
for %%I in ("%url_Python%") do set "filename_Python=%%~nxI"
set "python_folder=%filename_Python:~0,-4%"
for /f "tokens=2 delims=-" %%v in ("%filename_Python%") do set "version_Python=%%v"

REM Variables for Redis 6.0.20
set "url_Redis=https://github.com/redis-windows/redis-windows/releases/download/6.0.20/Redis-6.0.20-Windows-x64-msys2.zip"
for %%I in ("%url_Redis%") do set "filename_Redis=%%~nxI"
set "redis_folder=%filename_Redis:~0,-4%"
for /f "tokens=2 delims=-" %%v in ("%filename_Redis%") do set "version_Redis=%%v"

REM Variables for XpdfReader
set "url_XpdfReader=https://web.archive.org/web/20240303193546/https://dl.xpdfreader.com/xpdf-tools-win-4.05.zip"
for %%I in ("%url_XpdfReader%") do set "filename_XpdfReader=%%~nxI"
set "xpdfreader_folder=%filename_XpdfReader:~0,-4%"
for /f "tokens=2 delims=-" %%v in ("%filename_XpdfReader%") do set "version_XpdfReader=%%v"

REM Prepare migration file
mkdir src\conf 2>nul
if not exist "src\conf\migrations.txt" (
    type nul > "src\conf\migrations.txt"
)

REM Prepare packages folder
mkdir packages 2>nul

REM init env
set "PATH=%~dp0..\packages\%xpdfreader_folder%\bin64;%~dp0..\packages\%python_folder%\Scripts;%~dp0..\packages\%python_folder%;%~dp0..\packages\%php_folder%;%~dp0..\packages\%node_folder%;%PATH%"
REM Run migration
for %%i in ("src\migration\*.bat") do (
    findstr /i /c:"%%~nxi" "src\conf\migrations.txt" >nul || (
        echo Running %%~nxi
        call "%%i"
        if errorlevel 1 (
            echo %%~nxi did not execute successfully.
        ) else (
            echo %%~nxi executed successfully.
            echo %%~nxi>>"src\conf\migrations.txt"
        )
    )
)
