FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    default-mysql-client \
    gettext \
    libmemcached-dev \
    zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    gd \
    zip \
    gettext

# Install memcached extension
RUN pecl install memcached \
    && docker-php-ext-enable memcached

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configure Xdebug for detailed error tracing and debugging
RUN echo "\n\
; Xdebug configuration for error tracing and debugging\n\
xdebug.mode=debug,develop,trace\n\
xdebug.client_host=host.docker.internal\n\
xdebug.client_port=9003\n\
xdebug.start_with_request=yes\n\
xdebug.idekey=PHPSTORM\n\
\n\
; Error tracing settings\n\
xdebug.var_display_max_depth=10\n\
xdebug.var_display_max_children=512\n\
xdebug.var_display_max_data=2048\n\
\n\
; Stack trace settings\n\
xdebug.show_error_trace=1\n\
xdebug.show_exception_trace=1\n\
xdebug.show_local_vars=1\n\
xdebug.collect_params=4\n\
xdebug.collect_return=1\n\
xdebug.collect_assignments=1\n\
\n\
; Logging\n\
xdebug.log=/tmp/xdebug.log\n\
xdebug.log_level=7\n\
\n\
; Performance\n\
xdebug.profiler_enable=0\n\
xdebug.profiler_output_name=cachegrind.out.%p\n\
xdebug.profiler_output_dir=/tmp\n\
" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Enable Apache modules
RUN a2enmod rewrite headers deflate

# Configure Apache for high concurrency with prefork MPM
RUN echo "\n\
# High concurrency configuration\n\
<IfModule mpm_prefork_module>\n\
    StartServers             5\n\
    MinSpareServers          5\n\
    MaxSpareServers         10\n\
    MaxRequestWorkers      150\n\
    MaxConnectionsPerChild 3000\n\
</IfModule>\n" >> /etc/apache2/apache2.conf

# Configure Apache to allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Configure PHP error display
RUN echo "\n\
; Error handling\n\
error_reporting=E_ALL\n\
display_errors=On\n\
display_startup_errors=On\n\
log_errors=On\n\
error_log=/var/log/php_errors.log\n\
" >> /usr/local/etc/php/conf.d/error-handling.ini

WORKDIR /var/www/html

# Create a script to wait for MySQL and import database
RUN echo '#!/bin/bash\n\
# Use environment variables or fallback to defaults\n\
MYSQL_HOST=${MYSQL_HOST:-db}\n\
MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:-root}\n\
MYSQL_DATABASE=${MYSQL_DATABASE:-k1app_demo}\n\
MYSQL_USER=${MYSQL_USER:-k1app_user}\n\
MYSQL_PASSWORD=${MYSQL_PASSWORD:-k1app_user}\n\
\n\
echo "=== MySQL Connection Info ==="\n\
echo "MYSQL_HOST: $MYSQL_HOST"\n\
echo "MYSQL_DATABASE: $MYSQL_DATABASE"\n\
echo "=============================="\n\
\n\
echo "Waiting for MySQL to be ready..."\n\
\n\
# MySQL command with skip-ssl\n\
MYSQL_CMD="mysql -h $MYSQL_HOST -u root -p$MYSQL_ROOT_PASSWORD --skip-ssl"\n\
\n\
for i in {1..30}; do\n\
    echo "Attempt $i: Checking MySQL connection to $MYSQL_HOST..."\n\
    if $MYSQL_CMD -e "SELECT 1" 2>/dev/null; then\n\
        echo "✓ MySQL is ready!"\n\
        break\n\
    else\n\
        echo "✗ MySQL is unavailable - sleeping"\n\
        sleep 2\n\
    fi\n\
    if [ $i -eq 30 ]; then\n\
        echo "✗ Failed to connect to MySQL after 30 attempts"\n\
        exit 1\n\
    fi\n\
done\n\
\n\
echo "MySQL is up - checking database import"\n\
\n\
# Check if database exists\n\
DB_EXISTS=$($MYSQL_CMD -e "SHOW DATABASES LIKE \"$MYSQL_DATABASE\"" 2>/dev/null | grep "$MYSQL_DATABASE" | wc -l)\n\
\n\
if [ "$DB_EXISTS" -eq 0 ]; then\n\
    echo "Creating database and importing schema..."\n\
    $MYSQL_CMD -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE"\n\
    \n\
    # Create user and grant privileges\n\
    $MYSQL_CMD -e "\n\
        CREATE USER IF NOT EXISTS \"$MYSQL_USER\"@\"%\" IDENTIFIED BY \"$MYSQL_PASSWORD\";\n\
        GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO \"$MYSQL_USER\"@\"%\";\n\
        FLUSH PRIVILEGES;\n\
    "\n\
    \n\
    # Import SQL files from /docker-entrypoint-initdb.d\n\
    if [ -d /docker-entrypoint-initdb.d ] && [ -n "$(ls -A /docker-entrypoint-initdb.d 2>/dev/null)" ]; then\n\
        echo "Importing SQL files..."\n\
        for sqlfile in /docker-entrypoint-initdb.d/*.sql; do\n\
            echo "Importing $sqlfile"\n\
            $MYSQL_CMD "$MYSQL_DATABASE" < "$sqlfile"\n\
        done\n\
        echo "✓ Database import completed"\n\
    else\n\
        echo "No SQL files found in /docker-entrypoint-initdb.d"\n\
    fi\n\
else\n\
    echo "Database already exists, checking user..."\n\
    # Ensure user exists with proper privileges\n\
    $MYSQL_CMD -e "\n\
        CREATE USER IF NOT EXISTS \"$MYSQL_USER\"@\"%\" IDENTIFIED BY \"$MYSQL_PASSWORD\";\n\
        GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO \"$MYSQL_USER\"@\"%\";\n\
        FLUSH PRIVILEGES;\n\
    "\n\
fi\n\
\n\
echo "MySQL setup complete"\n\
' > /usr/local/bin/wait-for-mysql.sh && chmod +x /usr/local/bin/wait-for-mysql.sh

# Start Apache with wait script
CMD /usr/local/bin/wait-for-mysql.sh && apache2-foreground