FROM ubuntu:22.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=20

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ='Asia/Tokyo'

# タイムゾーン設定
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# 必要なパッケージと PHP PPA の追加
RUN apt-get update \
    && apt-get install -y software-properties-common libcap2-bin wget curl \
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update

# Supervisor のインストール
RUN apt-get install -y supervisor

# **PHP 8.1 の明示的なインストール**
RUN apt-get remove -y php-cli php-common \
    && apt-get install -y \
    php8.1-cli php8.1-dev \
    php8.1-pgsql php8.1-sqlite3 php8.1-gd \
    php8.1-curl php8.1-imap php8.1-mysql php8.1-mbstring \
    php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
    php8.1-intl php8.1-readline php8.1-ldap \
    php8.1-msgpack php8.1-igbinary php8.1-redis \
    php8.1-memcached php8.1-pcov php8.1-xdebug \
    php-pear

# **PEAR のインストール**
RUN apt-get install -y php-xml \
    && phpenmod xml \
    && php -m | grep xml \
    && wget http://pear.php.net/go-pear.phar -O /tmp/go-pear.phar \
    && echo -e "1\n" | php /tmp/go-pear.phar

# **PEAR の設定をリセット**
RUN pear config-set php_ini /etc/php/8.1/cli/php.ini system \
    && pear config-set auto_discover 1 \
    && pear upgrade --force \
    && pecl update-channels

# PECL チャネルの更新
RUN pecl channel-update pecl.php.net

# **Swoole のインストール（バージョン指定）**
RUN export PHP_VERSION=8.1 \
    && pecl install swoole-4.8.0 \
    && echo "extension=swoole.so" > /etc/php/$PHP_VERSION/cli/conf.d/20-swoole.ini

# **Composer のインストール**
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# **Node.js / npm のインストール**
RUN curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# **Yarn のインストール**
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /usr/share/keyrings/yarnkey.gpg > /dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/yarnkey.gpg] https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn

# **DB クライアントのインストール & クリーンアップ**
RUN apt-get install -y mysql-client postgresql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# **PHP のポート 80/443 使用許可**
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1

# **sail ユーザーの作成**
RUN groupadd --force -g $WWWGROUP sail \
    && useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

# **設定ファイルのコピー**
COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.1/cli/conf.d/99-sail.ini
RUN chmod +x /usr/local/bin/start-container

EXPOSE 8000

ENTRYPOINT ["start-container"]
