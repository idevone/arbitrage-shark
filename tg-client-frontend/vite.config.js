import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import { TanStackRouterVite } from "@tanstack/router-plugin/vite";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react(), TanStackRouterVite()],
  optimizeDeps: {},
  server: {
    headers: {
      port: 3000, // To run the app on port 3000
      open: true, // If we want to open the app once its started
      // https: true,
    },
  },
});
