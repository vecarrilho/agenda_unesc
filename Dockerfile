FROM ubuntu:trusty
 
# Install base packages
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get -yq install \
        curl \
        apache2 \
        libapache2-mod-php8.1.4 \
        php8.1.4-mysql \
        php8.1.4-mcrypt \
        php8.1.4-gd \
        php8.1.4-curl \
        php-pear \
        php-apc && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN /usr/sbin/php5enmod mcrypt
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i "s/variables_order.*/variables_order = \"EGPCS\"/g" /etc/php8.1.4/apache2/php.ini
 
ENV ALLOW_OVERRIDE **False**
 
# Add image configuration and scripts
ADD run.sh /run.sh
RUN chmod 755 /*.sh
 
# Configure /app folder with sample app
RUN mkdir -p /app && rm -fr /var/www/html && ln -s /app /var/www/html
ADD src/ /app
 
EXPOSE 80
WORKDIR /app
CMD ["/run.sh"]