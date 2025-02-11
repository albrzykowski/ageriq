# Używamy lekkiego obrazu Nginx
FROM nginx:alpine

# Ustawienie katalogu roboczego
WORKDIR /usr/share/nginx/html

# Usuwamy domyślny plik index.html Nginxa
RUN rm -rf ./*

# Kopiujemy zawartość folderu public do katalogu serwera
COPY public/ .

# Kopiujemy niestandardową konfigurację Nginx dla dev/test
COPY nginx.dev.conf /etc/nginx/conf.d/default.conf

# Eksponujemy port 80
EXPOSE 80

# Uruchamiamy Nginx
CMD ["nginx", "-g", "daemon off;"]