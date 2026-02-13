FROM php:8.3-apache

RUN apt-get update && \
    apt-get -y install apt-utils gnupg2 && \
    apt-get -y upgrade && \
    apt-get update --fix-missing && \
    apt-get --purge autoremove -y

RUN apt-get install -y \
#    openssl # \
    zip \
    zlib1g-dev \
    libzip-dev

# Install Python 3
RUN apt-get update && apt-get install -y \
    python3 \
    python3-venv \
    python3-full \
    curl

RUN apt-get update && apt-get install -y \
    libgl1 \
    libglib2.0-0 \
    libsm6 \
    libxext6 \
    libxrender1 \
 && rm -rf /var/lib/apt/lists/*


# Create Python virtual environment
RUN python3 -m venv /opt/pyenv

# Install pip inside the venv
RUN /opt/pyenv/bin/python -m pip install --upgrade pip

# Install Python libraries inside the venv
RUN /opt/pyenv/bin/pip install onnxruntime \
    numpy \
    opencv-python

# Make venv Python the default
RUN ln -s /opt/pyenv/bin/python /usr/local/bin/python \
    && ln -s /opt/pyenv/bin/pip /usr/local/bin/pip



RUN a2enmod rewrite proxy proxy_http proxy_wstunnel headers

RUN curl -sSLf \
    -o /usr/local/bin/install-php-extensions \
    https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions \
    gd \
    pdo pdo_mysql \
    mbstring \
    zip \
    redis \
    intl

# copy files
WORKDIR /var/www
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# install npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# install composer packages
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# cleanup
RUN rmdir /var/www/html && \
    chown -R www-data: /var/www
