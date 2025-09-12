# Changelog

All notable changes to this project after initial inspection (2025-09-12) are documented here.
Format: Added / Changed / Fixed / Removed / Internal. Dates use YYYY-MM-DD.

## [0.3.0] - 2025-09-12
### Added
- Full Ad CRUD: edit, update, delete for users and admins (`AdController@edit`, `update`, `destroy`).
- Authorization helper `authorizeAd()` with admin override.
- `resources/views/ads/edit.blade.php` allowing title/description/price/status changes, setting primary photo, uploading additional photos, and deleting the ad.
- Edit/Delete buttons in user dashboard (`home.blade.php`) and admin ads table (`admin/dashboard.blade.php`).
- Redirect logic: admin updates → admin ads list; user updates → user dashboard.

### Changed
- Admin & user listings now include action buttons and improved UX.
- Update flow now routes based on role instead of returning to edit page for users.

### Fixed
- Forbidden (403) on admin edit due to missing admin override in authorization.

### Removed
- Unused Profile & About links from user sidebar (`layouts/user.blade.php`).

### Internal
- Refined controller logic to centralize authorization and cleanup on delete (file + DB rows).

## [0.2.0] - 2025-09-12
### Added
- Public ad detail route `ads.show` with gallery (`ads/show.blade.php`).
- Clickable ad cards on homepage linking to individual ad pages.
- Placeholder SVG (`public/placeholder.svg`) for ads lacking real images.
- Fallback logic in `Ad` model `thumbnail_url` accessor to use placeholder when only text placeholder exists.

### Changed
- Show view swaps `.txt` seed placeholders for SVG placeholder automatically.

### Fixed
- 403 image access by creating storage symlink (`php artisan storage:link`).

## [0.1.1] - 2025-09-12
### Added
- Artisan command `ads:placeholders` to (re)generate placeholder images (PNG via GD or `.txt` fallback) for all ads.
- Console Kernel (`app/Console/Kernel.php`) & command class (`RegenerateAdPlaceholders`).

### Changed
- Seeder (`AdsTableSeeder`) updated to generate PNG placeholders when GD available.

### Fixed
- Prevent duplicate placeholder generation runs using options `--only-missing` and `--force`.

## [0.1.0] - 2025-09-12
### Added
- Ads feature: migrations (`create_ads_table`, `create_ad_photos_table`), models (`Ad`, `AdPhoto`) with relationships.
- Ad creation: form (`ads/create.blade.php`), multi-image upload, primary image selection (first uploaded by default).
- Listings: homepage grid (`welcome.blade.php`) with thumbnails; user dashboard restricted to own ads; admin dashboard ads view.
- Thumbnail accessor with eager loading optimization (`Ad::thumbnail_url`).
- Seeder improvements: `AdsTableSeeder` sample ads; idempotent `UsersTableSeeder` using `updateOrCreate`.
- Eager loaded relations in routes for performance.

### Changed
- Homepage layout from table to responsive card grid with hover effects.
- Admin dashboard supporting `?view=users` and `?view=ads` modes.

### Fixed
- Initial thumbnail non-rendering by correcting accessor & adding eager loading.

### Internal
- File structure additions: command & console directories, views for ads.
- Added deletion of image files on ad removal (later in 0.3.0 but foundational model logic prepared earlier).

---
## Pending / Not Yet Implemented (Suggestions)
- Image removal & reorder inside edit form.
- Slug-based ad URLs (`/ads/{id}-{slug}`) with route model binding.
- Policies / Gates replacing manual role checks.
- Pagination on user dashboard.
- Soft deletes for ads & photos.
- Search & filters (price range, status, keyword, user).
- Real image resizing & optimization (Intervention Image / Spatie Media Library).
- Category & tagging system.

---
## Usage Notes
- Ensure `php artisan storage:link` is run for image access.
- For real PNG placeholders, enable GD extension then run: `php artisan ads:placeholders --force`.
- Command help: `php artisan help ads:placeholders`.

## Versioning
- Semantic-style for feature increments; all versions here are same-day iterative milestones.

