const CACHE_NAME = "psweb-cache-v1";
const urlsToCache = [
  "/",
  "/admin/css/style.css",
  "/admin/js/template.js",
  "/admin/vendors/base/vendor.bundle.base.css",
  "/admin/vendors/base/vendor.bundle.base.js",
  "/admin/images/logo.svg"
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});
