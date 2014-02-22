#!/usr/bin/env bash
# Half-ass CSR/certificate generation from
# https://devcenter.heroku.com/articles/ssl-certificate-self


if [ -z $1 ]; then
  echo "Usage: $0 [domain_name]"
  exit
fi

domain=$1

openssl genrsa -des3 -passout pass:x -out $domain.pass.key 2048
openssl rsa -passin pass:x -in $domain.pass.key -out $domain.key
rm $domain.pass.key
subj="=/C=CA/ST=Ontario/L=Waterloo/O=EdgeLink Consulting/CN=$domain/emailAddress=support@edgelinkconsulting.com"
openssl req -new -key $domain.key -out $domain.csr -subj "$subj"
openssl x509 -req -days 3650 -in $domain.csr -signkey $domain.key -out $domain.crt

