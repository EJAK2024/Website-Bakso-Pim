FROM php:8.2-cli

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && node -v && npm -v

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# --- Layer 1: Install PHP deps ---
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# --- Layer 2: Install Node deps ---
COPY package.json package-lock.json* ./
RUN npm ci --legacy-peer-deps 2>/dev/null || npm install

# --- Layer 3: Copy source ---
COPY . .

# --- Layer 4: Build frontend ---
RUN npm run build

EXPOSE 8000

# --- Startup: migrate, storage link, cache, serve ---
CMD ["sh", "-c", "\
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan storage:link --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
