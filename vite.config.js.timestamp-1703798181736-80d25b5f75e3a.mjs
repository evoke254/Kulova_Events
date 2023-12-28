// vite.config.js
import { defineConfig } from "file:///home/kevin/Documents/Kulova/events/node_modules/vite/dist/node/index.js";
import laravel, { refreshPaths } from "file:///home/kevin/Documents/Kulova/events/node_modules/laravel-vite-plugin/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: [
        ...refreshPaths,
        "app/Filament/**",
        "app/Forms/Components/**",
        "app/Livewire/**",
        "app/Infolists/Components/**",
        "app/Providers/Filament/**",
        "app/Tables/Columns/**"
      ]
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvaG9tZS9rZXZpbi9Eb2N1bWVudHMvS3Vsb3ZhL2V2ZW50c1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiL2hvbWUva2V2aW4vRG9jdW1lbnRzL0t1bG92YS9ldmVudHMvdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL2hvbWUva2V2aW4vRG9jdW1lbnRzL0t1bG92YS9ldmVudHMvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJ1xuaW1wb3J0IGxhcmF2ZWwsIHsgcmVmcmVzaFBhdGhzIH0gZnJvbSAnbGFyYXZlbC12aXRlLXBsdWdpbidcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFsncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJywgJ3Jlc291cmNlcy9qcy9hcHAuanMnXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IFtcbiAgICAgICAgICAgICAgICAuLi5yZWZyZXNoUGF0aHMsXG4gICAgICAgICAgICAgICAgJ2FwcC9GaWxhbWVudC8qKicsXG4gICAgICAgICAgICAgICAgJ2FwcC9Gb3Jtcy9Db21wb25lbnRzLyoqJyxcbiAgICAgICAgICAgICAgICAnYXBwL0xpdmV3aXJlLyoqJyxcbiAgICAgICAgICAgICAgICAnYXBwL0luZm9saXN0cy9Db21wb25lbnRzLyoqJyxcbiAgICAgICAgICAgICAgICAnYXBwL1Byb3ZpZGVycy9GaWxhbWVudC8qKicsXG4gICAgICAgICAgICAgICAgJ2FwcC9UYWJsZXMvQ29sdW1ucy8qKicsXG4gICAgICAgICAgICBdLFxuICAgICAgICB9KSxcbiAgICBdLFxufSlcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBMlIsU0FBUyxvQkFBb0I7QUFDeFQsT0FBTyxXQUFXLG9CQUFvQjtBQUV0QyxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPLENBQUMseUJBQXlCLHFCQUFxQjtBQUFBLE1BQ3RELFNBQVM7QUFBQSxRQUNMLEdBQUc7QUFBQSxRQUNIO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxNQUNKO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
