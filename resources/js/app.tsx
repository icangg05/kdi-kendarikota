import "../css/app.css";
import "./bootstrap";

import "swiper/css";
import "swiper/css/autoplay";
import "swiper/css/effect-fade";

import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createRoot } from "react-dom/client";

// const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
  title: (title) =>
    title ? title : "Portal Resmi Pemerintah Daerah Kota Kendari",
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.tsx`,
      import.meta.glob("./Pages/**/*.tsx")
    ),
  setup({ el, App, props }) {
    const root = createRoot(el);

    root.render(<App {...props} />);
  },
  progress: {
    color: "#2973B2",
  },
});
