const CACHE_NAME = 'pwa-example-v1';
const ASSETS = [
  '/index.php/login',
  '/styles.css',
  './icons/favicon-psweb-192.png',
  './icons/favicon-psweb-512.png'
];

// Instala o Service Worker e armazena os arquivos em cache
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(ASSETS))
      .then(() => self.skipWaiting())
  );
});

// Intercepta as requisições e serve os arquivos do cache
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request)
      .then((response) => response || fetch(event.request))
  );
});