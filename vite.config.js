import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    plugins: [
        laravel({
            // Nota: ai [name] che terminano con 'main' e 'default' viene comunque aggiunto una hash.
            // Lista dei file da processare con l'opzione 'build' seguente.
            // Nota: specificando un object (anziché un array di input files), è possibile rinominare
            //       il nome di destinazione di ogni input file tramite il proprio key-name.
            // Nota: il rename tramite key-name non sembra funzionare per i file .css.
            input: {
                scripts: 'resources/js/scripts.js',
                admin: 'resources/js/admin.js',
                inputs: 'resources/js/inputs.js',
                storage: 'resources/js/storage.js',
                styles: 'resources/css/styles.css',
            },
            refresh: true,
        }),
        viteStaticCopy({
            // Destinazione: '.'  =>  outDir (vedi sotto).
            // File da copiare senza complilazione ed eventuale build.minify (dest è relativo a outDir).
            // Nota: è possibile copiare anche delle directories, incluso il loro contenuto, se src
            //       specifica il path di una directory (è possibile specificare '.' come dest => outDir).
            // Nota: vedi file 'node_modules\vite-plugin-static-copy\dist\index.d.ts' per ulteriori
            //       properties non documentate in:
            //         https://github.com/sapphi-red/vite-plugin-static-copy
            targets: [
                { src: 'resources/js/statics/*.js', dest: 'js', preserveTimestamps: true },
                { src: 'node_modules/tw-elements/dist/js/tw-elements.umd.min.js', dest: 'js',
                  rename: 'tw-elements.js', preserveTimestamps: true },
                { src: 'node_modules/showdown/dist/showdown.min.js', dest: 'js',
                  rename: 'showdown.js', preserveTimestamps: true },
                { src: 'resources/css/statics/*.css', dest: 'css', preserveTimestamps: true },
            ],
        }),
    ],

    build: {
        outDir: 'public/build',  // Nota: in modalità 'build', il file 'manifest.json' viene creato
                                 //       nella directory outDir, ma lo statement @vite() lo cerca
                                 //       sempre nella directory 'public/build' indipendentemente
                                 //       dal path impostato in questa property.
                                 //       Inoltre, i link generati dallo  statement @vite() sono
                                 //       sempre relativi a 'public/build' (outDir ignorato).
        minify: false,
        // L'opzione minify è abilitata per default, il comando 'buildloop' la disabilita e attiva
        // invece l'opzione 'watch' (vedi file "package.json" nella root del progetto).
        rollupOptions: {
            // L'opzione 'external' evita che i riferimenti "../../fonts/<fontName>" all'interno di
            // 'resources/css/helvetica-neue.css' (importati in 'resources/css/styles.css') generino
            // il warning:
            //   ... didn't resolve at build time, it will remain unchanged to be resolved at runtime.
            // Nota: la directory 'fonts' si trova già nella directory 'public', se si trovasse nella
            //       directory 'resources/fonts' (e poi copiata in 'public' tramite viteStaticCopy),
            //       allora i riferimenti "../../fonts/<fontName>" sarebbero risolti anche 'at build time'
            //       e, di conseguenza, le font stesse sarebbero copiate nella directory 'css'
            //       dall'opzione output.assetFileNames.
            external: [ /^(?:\.\.\/)?\.\.\/fonts\/.+$/i ],  // Il path risale di uno o due parenti.
            output: {
                // Nota: i [name] che terminano con 'main' e 'default' aggiungono comunque l'hash.
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: 'css/[name].[ext]',
            }
        }
    },
});
