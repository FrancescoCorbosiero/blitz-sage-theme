/**
 * Blitz Theme Service Worker
 * Handles offline functionality and caching strategies
 */

const CACHE_VERSION = 'blitz-v1.0.0';
const CACHE_NAME = `${CACHE_VERSION}`;

// Assets to cache on install
const PRECACHE_URLS = [
  '/',
  '/offline.html',
];

// Cache strategies per route type
const CACHE_STRATEGIES = {
  pages: 'network-first',
  assets: 'cache-first',
  api: 'network-only',
  images: 'cache-first'
};

/**
 * Install event - precache essential assets
 */
self.addEventListener('install', (event) => {
  console.log('[SW] Installing service worker...');
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('[SW] Precaching assets');
        return cache.addAll(PRECACHE_URLS);
      })
      .then(() => self.skipWaiting())
  );
});

/**
 * Activate event - clean old caches
 */
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating service worker...');
  
  event.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames
            .filter(name => name !== CACHE_NAME)
            .map(name => {
              console.log('[SW] Deleting old cache:', name);
              return caches.delete(name);
            })
        );
      })
      .then(() => self.clients.claim())
  );
});

/**
 * Fetch event - handle requests with appropriate strategy
 */
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip non-GET requests
  if (request.method !== 'GET') return;

  // Skip admin and preview requests
  if (url.pathname.includes('/wp-admin') || url.searchParams.has('preview')) {
    return;
  }

  // Determine strategy based on request type
  const strategy = getStrategy(request);

  event.respondWith(
    handleRequest(request, strategy)
  );
});

/**
 * Determine caching strategy for request
 */
function getStrategy(request) {
  const url = new URL(request.url);
  
  // Images
  if (request.destination === 'image') {
    return CACHE_STRATEGIES.images;
  }
  
  // JS/CSS assets
  if (request.destination === 'script' || request.destination === 'style') {
    return CACHE_STRATEGIES.assets;
  }
  
  // API calls
  if (url.pathname.includes('/wp-json/') || url.pathname.includes('/wp-admin/admin-ajax.php')) {
    return CACHE_STRATEGIES.api;
  }
  
  // Pages (HTML)
  return CACHE_STRATEGIES.pages;
}

/**
 * Handle request with specified strategy
 */
async function handleRequest(request, strategy) {
  switch (strategy) {
    case 'cache-first':
      return cacheFirst(request);
    
    case 'network-first':
      return networkFirst(request);
    
    case 'network-only':
      return networkOnly(request);
    
    default:
      return fetch(request);
  }
}

/**
 * Cache-first strategy
 */
async function cacheFirst(request) {
  const cached = await caches.match(request);
  
  if (cached) {
    console.log('[SW] Serving from cache:', request.url);
    return cached;
  }
  
  try {
    const response = await fetch(request);
    
    if (response.ok) {
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    console.error('[SW] Fetch failed:', error);
    return getOfflineFallback(request);
  }
}

/**
 * Network-first strategy
 */
async function networkFirst(request) {
  try {
    const response = await fetch(request);
    
    if (response.ok) {
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    console.log('[SW] Network failed, trying cache:', request.url);
    
    const cached = await caches.match(request);
    if (cached) {
      return cached;
    }
    
    return getOfflineFallback(request);
  }
}

/**
 * Network-only strategy
 */
async function networkOnly(request) {
  return fetch(request);
}

/**
 * Get offline fallback
 */
async function getOfflineFallback(request) {
  // For HTML pages, return offline page
  if (request.destination === 'document') {
    const offline = await caches.match('/offline.html');
    if (offline) return offline;
  }
  
  // Return a simple offline response
  return new Response('Offline', {
    status: 503,
    statusText: 'Service Unavailable',
    headers: new Headers({
      'Content-Type': 'text/plain'
    })
  });
}

/**
 * Handle messages from clients
 */
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

console.log('[SW] Service worker loaded');