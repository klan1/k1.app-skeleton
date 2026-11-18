#!/bin/bash

# Load .env file if it exists
if [ -f .env ]; then
    echo "Loading configuration from .env file..."
    export $(grep -v '^#' .env | xargs)
else
    echo "No .env file found, using defaults..."
    # Set default values if .env doesn't exist
    MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:-rootpass}
    MYSQL_DATABASE=${MYSQL_DATABASE:-testdb}
    MYSQL_USER=${MYSQL_USER:-testuser}
    MYSQL_PASSWORD=${MYSQL_PASSWORD:-testpass}
    MYSQL_PORT=${MYSQL_PORT:-3306}
    APACHE_PORT=${APACHE_PORT:-8080}
fi

# Create necessary directories (only for configuration, NOT database data)
echo "Creating configuration directories..."
mkdir -p database
mkdir -p apache

# Create default tuning.conf if it doesn't exist
if [ ! -f apache/tuning.conf ]; then
    echo "Creating default apache/tuning.conf..."
    cat > apache/tuning.conf << 'EOF'
# Apache tuning configuration
# Add your custom Apache configuration here

# Example: Increase timeout for long-running requests
# Timeout 300

# Example: Adjust keep-alive settings
# KeepAlive On
# MaxKeepAliveRequests 100
# KeepAliveTimeout 5
EOF
fi

# Check if database directory has SQL files, but DO NOT create any
if [ -z "$(ls -A database 2>/dev/null)" ]; then
    echo "Note: database/ directory is empty. Place your .sql files here for initialization."
fi

# Create .env.example file for reference if it doesn't exist
if [ ! -f .env.example ]; then
    echo "Creating .env.example file..."
    cat > .env.example << 'EOF'
# Database Configuration
MYSQL_ROOT_PASSWORD=rootpass
MYSQL_DATABASE=testdb
MYSQL_USER=testuser
MYSQL_PASSWORD=testpass
MYSQL_PORT=3306

# Apache Configuration
APACHE_PORT=8080

# Application Configuration
# Add any other environment variables your app needs here
EOF
fi

# Create .gitignore for the docker directory if it doesn't exist
if [ ! -f .gitignore ]; then
    echo "Creating .gitignore..."
    cat > .gitignore << 'EOF'
# Docker data directories (DO NOT create these manually)
db_data/

# Environment files with sensitive data
.env

# OS files
.DS_Store
Thumbs.db
EOF
fi

# Display configuration summary
echo ""
echo "========================================="
echo "Setup completed with the following configuration:"
echo "-----------------------------------------"
echo "Database:"
echo "  Host: localhost:${MYSQL_PORT}"
echo "  Database: ${MYSQL_DATABASE}"
echo "  User: ${MYSQL_USER}"
echo "  Password: ${MYSQL_PASSWORD}"
echo "  Root Password: ${MYSQL_ROOT_PASSWORD}"
echo "-----------------------------------------"
echo "Application:"
echo "  URL: http://localhost:${APACHE_PORT}"
echo "========================================="
echo ""

# Check if database directory has SQL files
if [ -d "database" ] && [ -n "$(ls -A database 2>/dev/null)" ]; then
    echo "✓ Found SQL files in database/ directory:"
    ls -la database/
    echo ""
else
    echo "⚠ No SQL files found in database/ directory"
    echo "   Place your .sql files in the database/ directory for automatic initialization"
    echo ""
fi

echo "Important: DO NOT create the db_data directory manually!"
echo "MySQL container will create it automatically with correct permissions."
echo ""

# Check if db_data exists and warn if it does
if [ -d "db_data" ]; then
    echo "⚠ WARNING: db_data directory exists!"
    echo "   This directory should be managed by Docker only."
    echo "   If you're having issues, remove it with: rm -rf db_data"
    echo "   Then restart the containers."
    echo ""
fi

# Ask if user wants to start the containers
read -p "Do you want to start the containers now? (y/n) " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "Starting containers..."
    
    # Check if db_data exists and warn
    if [ -d "db_data" ]; then
        echo "⚠ db_data directory exists - this may cause permission issues"
        echo "   If you encounter MySQL errors, stop containers and run:"
        echo "   docker-compose down -v && rm -rf db_data"
        echo ""
    fi
    
    docker-compose up -d
    
    echo ""
    echo "✓ Containers started!"
    echo ""
    echo "To check logs: docker-compose logs -f"
    echo "To stop: docker-compose down"
    echo "To stop and remove database: docker-compose down -v"
    echo ""
    echo "Application available at: http://localhost:${APACHE_PORT}"
    echo "MySQL available at: localhost:${MYSQL_PORT}"
    echo "  Username: ${MYSQL_USER}"
    echo "  Password: ${MYSQL_PASSWORD}"
else
    echo "Setup complete. To start the containers, run:"
    echo "  cd docker"
    echo "  docker-compose up -d"
    echo ""
    echo "Note: The db_data directory will be created automatically by Docker"
    echo "      Do NOT create it manually to avoid permission issues."
fi