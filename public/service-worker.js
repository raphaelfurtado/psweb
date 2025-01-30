const CACHE_NAME = 'pwa-example-v1';
const ASSETS = [
  '/', 
  './icons/favicon-psweb-192.png',  // Ícones agora são locais
  './icons/favicon-psweb-512.png'
];

// Instala o Service Worker e armazena os arquivos em cache
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return Promise.all(
        ASSETS.map((asset) => 
          fetch(asset, { mode: 'no-cors' }) // Tenta evitar problemas de CORS
            .then((response) => {
              if (!response.ok && response.type !== 'opaque') {
                throw new Error(`Erro ao buscar ${asset}: ${response.statusText}`);
              }
              return cache.put(asset, response);
            })
            .catch((error) => console.warn(`Falha ao adicionar ${asset} ao cache:`, error))
        )
      );
    })
  );
});

// Intercepta as requisições e serve os arquivos do cache
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => response || fetch(event.request))
  );
});
