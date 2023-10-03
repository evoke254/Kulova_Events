import './bootstrap';

import Alpine from 'alpinejs';
import 'flowbite';
window.Alpine = Alpine;

import './index.js';

import focus from '@alpinejs/focus';
Alpine.plugin(focus);

Alpine.start();
