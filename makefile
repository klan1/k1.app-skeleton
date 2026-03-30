.PHONY: help up down restart logs shell ps build clean status test db-shell db-import

# Colors for output
GREEN := \033[0;32m
RED := \033[0;31m
YELLOW := \033[0;33m
NC := \033[0m # No Color

# Default target
help:
	@echo "$(GREEN)Docker Management Commands$(NC)"
	@echo "========================================="
	@echo "$(YELLOW)Development:$(NC)"
	@echo "  make up          - Start containers in detached mode"
	@echo "  make down        - Stop containers"
	@echo "  make restart     - Restart containers"
	@echo "  make logs        - Follow container logs"
	@echo "  make ps          - Show running containers"
	@echo "  make status      - Show container status with details"
	@echo ""
	@echo "$(YELLOW)Database:$(NC)"
	@echo "  make db-shell    - Access MySQL shell as root"
	@echo "  make db-import   - Import SQL file (usage: make db-import FILE=path/to/file.sql)"
	@echo "  make db-export   - Export database (usage: make db-export FILE=path/to/export.sql)"
	@echo "  make db-reset    - Reset database (delete and recreate)"
	@echo ""
	@echo "$(YELLOW)Cleanup:$(NC)"
	@echo "  make clean       - Stop containers and remove volumes (preserves data)"
	@echo "  make clean-all   - Remove everything: containers, volumes, images, and data"
	@echo "  make prune       - Remove all unused Docker resources"
	@echo ""
	@echo "$(YELLOW)Building:$(NC)"
	@echo "  make build       - Rebuild containers"
	@echo "  make rebuild     - Rebuild and restart containers"
	@echo ""
	@echo "$(YELLOW)Testing:$(NC)"
	@echo "  make test        - Run tests"
	@echo "  make test-coverage- Run tests with coverage"
	@echo ""
	@echo "$(YELLOW)Utilities:$(NC)"
	@echo "  make shell       - Access web container shell"
	@echo "  make logs-web    - Show web container logs"
	@echo "  make logs-db     - Show database container logs"

# Start containers
up:
	@cd docker && docker-compose up -d
	@echo "$(GREEN)✓ Containers started$(NC)"
	@make ps

# Stop containers
down:
	@cd docker && docker-compose down
	@echo "$(YELLOW)✓ Containers stopped$(NC)"

# Restart containers
restart: down up

# Follow logs
logs:
	@cd docker && docker-compose logs -f

# Show running containers
ps:
	@cd docker && docker-compose ps

# Show detailed status
status:
	@echo "$(GREEN)Container Status:$(NC)"
	@cd docker && docker-compose ps
	@echo ""
	@echo "$(GREEN)Resource Usage:$(NC)"
	@docker stats --no-stream
	@echo ""
	@echo "$(GREEN)Database Status:$(NC)"
	@docker exec -it docker-db-1 mysql -uroot -prootpass -e "SHOW DATABASES;" 2>/dev/null || echo "Database not running"

# Build containers
build:
	@cd docker && docker-compose build
	@echo "$(GREEN)✓ Containers built$(NC)"

# Rebuild and restart
rebuild: build restart

# Clean (stop and remove containers, preserve volumes)
clean:
	@cd docker && docker-compose down
	@echo "$(YELLOW)✓ Containers removed (data preserved in volumes)$(NC)"

# Clean all (remove containers, volumes, and data)
clean-all:
	@cd docker && docker-compose down -v
	@echo "$(RED)✓ Containers, volumes, and data removed$(NC)"
	@echo "  To start fresh, run: make up"

# Remove all unused Docker resources
prune:
	@docker system prune -af
	@echo "$(RED)✓ Unused Docker resources removed$(NC)"

# Access web container shell
shell:
	@cd docker && docker-compose exec web bash

# Access database shell
db-shell:
	@cd docker && docker-compose exec db mysql -uroot -prootpass

# Import SQL file (usage: make db-import FILE=path/to/file.sql)
db-import:
	@if [ -z "$(FILE)" ]; then \
		echo "$(RED)Error: Please specify FILE$(NC)"; \
		echo "Usage: make db-import FILE=path/to/file.sql"; \
		exit 1; \
	fi
	@if [ ! -f "$(FILE)" ]; then \
		echo "$(RED)Error: File $(FILE) not found$(NC)"; \
		exit 1; \
	fi
	@echo "$(YELLOW)Importing $(FILE)...$(NC)"
	@cat $(FILE) | cd docker && docker-compose exec -T db mysql -uroot -prootpass testdb
	@echo "$(GREEN)✓ Import completed$(NC)"

# Export database (usage: make db-export FILE=path/to/export.sql)
db-export:
	@if [ -z "$(FILE)" ]; then \
		echo "$(RED)Error: Please specify FILE$(NC)"; \
		echo "Usage: make db-export FILE=path/to/export.sql"; \
		exit 1; \
	fi
	@echo "$(YELLOW)Exporting database to $(FILE)...$(NC)"
	@cd docker && docker-compose exec -T db mysqldump -uroot -prootpass testdb > $(FILE)
	@echo "$(GREEN)✓ Export completed to $(FILE)$(NC)"

# Reset database (delete and recreate)
db-reset:
	@echo "$(RED)WARNING: This will delete all database data!$(NC)"
	@read -p "Are you sure? (y/n) " -n 1 -r; \
	echo; \
	if [[ $$REPLY =~ ^[Yy]$$ ]]; then \
		echo "$(YELLOW)Resetting database...$(NC)"; \
		cd docker && docker-compose exec -T db mysql -uroot -prootpass -e "DROP DATABASE IF EXISTS testdb; CREATE DATABASE testdb;"; \
		if [ -d "docker/database" ] && [ -n "$$(ls -A docker/database 2>/dev/null)" ]; then \
			echo "$(YELLOW)Importing SQL files...$(NC)"; \
			for file in docker/database/*.sql; do \
				echo "Importing $$file..."; \
				cat $$file | cd docker && docker-compose exec -T db mysql -uroot -prootpass testdb; \
			done; \
		fi; \
		echo "$(GREEN)✓ Database reset completed$(NC)"; \
	else \
		echo "$(YELLOW)Cancelled$(NC)"; \
	fi

# Show web container logs
logs-web:
	@cd docker && docker-compose logs -f web

# Show database container logs
logs-db:
	@cd docker && docker-compose logs -f db

# Run tests
test:
	@cd docker && docker-compose -f docker-compose.test.yml run --rm app-test

# Run tests with coverage
test-coverage:
	@cd docker && docker-compose -f docker-compose.test.yml run --rm app-test phpunit --coverage-html coverage
	@echo "$(GREEN)✓ Coverage report generated in docker/coverage/$(NC)"

# Development mode (with logs)
dev: up logs

# Quick status check
status-quick:
	@cd docker && docker-compose ps
	@echo ""
	@echo "Web: http://localhost:8080"
	@echo "MySQL: localhost:3306"

# Show disk usage
disk-usage:
	@echo "$(GREEN)Docker Disk Usage:$(NC)"
	@docker system df
	@echo ""
	@echo "$(GREEN)Container Sizes:$(NC)"
	@docker ps --size

# Initialize fresh environment
fresh: clean-all db-reset up
	@echo "$(GREEN)✓ Fresh environment created$(NC)"

# Default target
default: help