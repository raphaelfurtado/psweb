const CACHE_NAME = 'pwa-example-v1';
const ASSETS = [
  '/',
  '/index.html',
  '/styles.css',
  'https://via.placeholder.com/192x192.png?text=Ícone+192x192',
  'https://via.placeholder.com/512x512.png?text=Ícone+512x512'
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