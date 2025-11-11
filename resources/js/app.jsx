import './bootstrap';
import '../css/app.css'

import { createInertiaApp } from '@inertiajs/react'
import { createRoot } from 'react-dom/client'
import Layout from "./Pages/components/Layout.jsx";

import.meta.glob([
    '../images/**'
]);

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.jsx')
        const loader = pages[`./Pages/${name}.jsx`];
        if (!loader) {
            throw new Error(`Page component not found: ./Pages/${name}.jsx`)
        }

        return loader().then(page => {
            page.default.layout = page.default.layout ?? ((page) => <Layout>{page}</Layout>)
            return page
        })
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props}/>)
    },
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,

        // The color of the progress bar...
        color: '#29d',

        // Whether to include the default NProgress styles...
        includeCSS: true,

        // Whether the NProgress spinner will be shown...
        showSpinner: false,
    },
    defaults: {
        future: {
            useDataInertiaHeadAttribute: true,
        },
    },
})
