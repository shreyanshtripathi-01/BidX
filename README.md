# BidX
### Premium Heritage & Collectibles Auction Portal

BidX is a high-fidelity online auction platform designed for the Indian collectors' market. The platform features a bespoke Obsidian & Bronze aesthetic, bringing the atmosphere of a physical, premium auction house online.

From royal numismatics and royal textiles to vintage automobilia, BidX is custom-engineered to manage high-value physical asset vetting, bidding escrow, and seamless bidder coordination.

---

## Core Pillars & Features

### 1. Obsidian & Bronze Aesthetic
* **Elite Color Palette:** Built using a bespoke obsidian-warm charcoal base (#0A0A0A / #121212) accented by elegant champagne bronze (#C5A880) styling.
* **Flicker-Free Theme Toggling:** Fast light/dark state transitions powered by class-based local storage hooks.
* **Typography:** System-wide Figtree sans-serif typography.

### 2. High-Fidelity Bidding Mechanics
* **Bespoke Bidding Calculators:** Dynamic Indian Rupee (₹) bidding logs with active integer calculations (zero floating-point anomalies).
* **Anti-Collusion Unique Guard:** Each bidder is strictly limited to exactly one active row in the live bids ledger per lot. Outbids calculate dynamically on conflict to maintain absolute transaction transparency.
* **Real-time outbid notifications:** Outbid logs and status updates to instantly notify users when their bids are surpassed.

### 3. Collector's 3-Phase Escrow Workflow
* **Physical Asset Vetting:** Every item undergoes hands-on authentication by specialists before being cataloged.
* **Transparent Bidding:** Fair-play active auctions with public bidding ledgers.
* **White-Glove Escrow Logistics:** High-security transit and payment protection upon successful bid closure.

---

## Technical Architecture

* **Backend Framework:** Laravel 11 (PHP 8.2+)
* **Frontend Compiler:** Vite + Tailwind CSS
* **Database Layer:** Robust MySQL / SQLite schema configurations
* **Identity Management:** Laravel Breeze (Custom Rebranded)

---

## Running Locally

### 1. Set Up Environment Variables
Configure your database inside `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=auction_platform
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Install Dependencies & Seed
```bash
composer install
npm install
php artisan migrate:fresh --seed
```

### 3. Boot Up Servers
Open two terminal windows side-by-side:

* **Backend Process:**
  ```bash
  php artisan serve
  ```
* **Frontend Compiler:**
  ```bash
  npm run dev
  ```

Access the dashboard at: http://127.0.0.1:8000

---

## Production & Deployment

BidX is built with a continuous deployment lifecycle, utilizing Railway.app connected directly to GitHub. 

* **Hosting Architecture:** Containerized PHP & Node runtime via Nixpacks.
* **Database Connection:** Multi-service orchestration linking the web frontend with a dedicated MySQL replica inside the secure VPC.
