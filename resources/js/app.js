import 'flowbite';


import './index.js';
// Require puppeteer
const puppeteer = require('puppeteer');

(async () => {
    // Create an instance of the chrome browser
    // But disable headless mode !
    const browser = await puppeteer.launch({
       // executablePath: '/usr/bin/chromium-browser',
        headless: false
    });

    // Create a new page
    const page = await browser.newPage();

    // Configure the navigation timeout
    await page.setDefaultNavigationTimeout(0);

    // Do your stuff
    // ...
})();
