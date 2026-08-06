# Smart Hearing style WordPress website

WordPress core is installed in this folder. The custom homepage lives in:

`wp-content/themes/rlx-signal`

## Local preview

The included WordPress Playground workflow runs a real WordPress instance with SQLite, so no local PHP or MySQL installation is required.

```powershell
npm install
npm run preview:server
```

Open `http://127.0.0.1:9400`.

## Standard hosting

Upload this WordPress folder to the server, create a database, complete the normal WordPress installer, then activate **RLX Signal** under Appearance → Themes.

Contact defaults can be edited under Appearance → Customize → 睿聲聯絡資料.
