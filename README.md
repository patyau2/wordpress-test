# Smart Hearing style WordPress website

WordPress core is installed in this folder. The custom homepage lives in:

`wp-content/themes/rlx-signal`

The homepage is database-backed. On first activation, the theme seeds editable WordPress records for:

- Hero slides
- News
- Hearing content
- Brands
- Promotion tiles
- Standard destination pages and archives
- Reservation requests, stored privately in WordPress
- Contact, footer, and homepage copy under Appearance -> Customize

## Local preview

The included WordPress Playground workflow runs a real WordPress instance with SQLite, so no local PHP or MySQL installation is required.

```powershell
npm install
npm run preview:server
```

Open `http://127.0.0.1:9400`.

## Standard hosting

Upload this WordPress folder to the server, create a database, complete the normal WordPress installer, then activate **RLX Signal** under Appearance → Themes.

`wp-config.php` is intentionally gitignored because it contains database credentials and salts. Production should use the host-generated `wp-config.php` or one populated from secure environment variables.

After activation, edit homepage content in WP Admin:

- RLX Hero slides
- RLX News
- RLX Hearing content
- RLX Brands
- RLX Promotion tiles
- Pages (About, Appointment, Stores, Subsidy, Privacy, Sitemap, and offer pages)
- Reservation requests
- Appearance -> Menus
- Appearance -> Customize -> 睿聲聯絡資料 / 睿聲首頁內容
