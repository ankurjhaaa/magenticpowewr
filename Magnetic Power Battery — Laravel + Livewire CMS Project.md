# Magnetic Power Battery — Laravel + Livewire CMS Project

Bhai, main ek **Magnetic Power Battery** naam ki company ke liye professional business website bana raha hoon.

Tech stack:

- Laravel
- Livewire
- Blade
- Tailwind CSS
- MySQL
- Public website ke liye normal Laravel Blade
- Admin panel ke liye Livewire + Tailwind CSS

**React, Vue, Bootstrap ya koi unnecessary frontend framework introduce mat karna.**

---

# 1. Project ka main purpose

Ye website **e-commerce website nahi hai**.

Website ka main purpose hai company ke battery products ko showcase karna aur users se enquiry generate karna.

Company ke products/services mein mainly:

- LFP Lithium-ion Batteries
- NMC Lithium-ion Batteries
- EV Battery Packs
- Customized Battery Solutions
- BMS Integrated Battery Packs
- Electric Mobility Battery Solutions
- Energy Storage Solutions

Users website par:

- Battery categories dekh sake
- Products dekh sake
- Product details dekh sake
- Product ke available variants dekh sake
- Variant ki specifications/images dekh sake
- Enquiry bhej sake
- Contact form submit kar sake
- Specific battery variant ke liye WhatsApp par enquiry kar sake

Website par:

- Cart nahi hoga
- Checkout nahi hoga
- Payment nahi hoga
- Online direct selling nahi hogi

Ye basically **product showcase + enquiry generation business website** hogi.

---

# 2. Sabse important Product Architecture

Project ka sabse important database concept ye hai:

**Category → Product → Variant**

Product parent entity hoga aur uske andar multiple variants ho sakte hain.

Example:

Category:

```text
LFP Batteries
```

Product:

```text
LFP EV Battery
```

Variants:

```text
48V 30Ah
48V 40Ah
60V 40Ah
72V 50Ah
```

Important:

**User ultimately specific variant ke liye enquiry karega.**

Isliye architecture aisa nahi hona chahiye jahan user sirf generic product ko enquire kare.

Variant actual enquiry-level entity hoga.

Mere dost Ankur ne bhi specifically suggest kiya hai:

> Product ko directly call nahi karna hai, variant ko call karenge.

Isliye database design mein `product_variants` ko properly design karna.

---

# 3. Brand ka separate table

Brand ka apna separate table hona chahiye.

Product table ke andar sirf plain text brand name store nahi karna.

Relationship:

```text
Brand hasMany Products

Product belongsTo Brand
```

Future mein multiple brands add ho sakte hain, isliye proper relational structure banana hai.

---

# 4. Website CMS hogi

Website ka business/content related data hardcoded nahi hona chahiye.

Admin panel se eventually ye sab manage ho:

```text
Categories
Brands
Products
Product Variants
Product Images
Variant Images
Applications
Specifications
Variant Specifications
Enquiries
Contact Messages
Company Information
Team Members
Homepage Banners
FAQs
Website Settings
Contact Information
Social Links
```

Public website ye data database se fetch karegi.

Lekin ek important baat:

**Har HTML section, div ya layout ko database mein store nahi karna hai.**

Actual page structure/layout Blade components/code mein reh sakta hai.

Database mein mainly **dynamic business/content data** hona chahiye.

Matlab:

```text
Layout = Code

Content/Data = Database
```

Ye maintainable CMS architecture hoga.

---

# 5. Recommended Database Architecture

Initial architecture roughly ye hai:

```text
users

categories
brands
products
product_variants

product_images
variant_images

applications
variant_applications

specifications
variant_specifications

inquiries
contact_messages

company_profiles
team_members

banners
faqs

settings
```

Abhi isko blindly final mat maan lena.

Pehle requirements analyze karo aur agar koi table missing hai ya unnecessary hai toh clearly batao.

Goal ye nahi hai ki database bas "bada" ho.

Goal hai:

**Normalized + Scalable + Maintainable + Practical database.**

---

# 6. Product Variants aur Specifications

Variant mein kuch important fields proper columns ke roop mein ho sakte hain.

Example:

```text
voltage
capacity
chemistry
```

Lekin future mein client naye specifications add kar sakta hai.

Example:

```text
BMS
Cycle Life
Weight
Charging Time
IP Rating
Warranty
etc.
```

Isliye dynamic specifications ka system bhi chahiye:

```text
specifications
variant_specifications
```

Example:

Specification:

```text
BMS
```

Value:

```text
40A
```

Another:

```text
Cycle Life
```

Value:

```text
2000+
```

Iska fayda ye hoga ki future mein new specification add karne ke liye migration mein new column add nahi karna padega.

Lekin isko unnecessarily over-engineer mat karna.

---

# 7. Images

Product aur variant ke multiple images ho sakte hain.

Images ko directly product/variant table mein multiple columns ke form mein store nahi karna.

Separate tables use karna:

```text
product_images
variant_images
```

System ko support karna chahiye:

- Multiple images
- Primary image
- Image sorting/order
- Alt text

---

# 8. Applications

Company different applications ke liye batteries manufacture karti hai.

Examples:

```text
Electric Scooters
Electric Rickshaws
Electric Vehicles
Energy Storage
Custom Applications
```

Applications ka separate table hona chahiye.

Ek variant multiple applications mein use ho sakta hai.

Isliye many-to-many relationship:

```text
variants
    ↕
variant_applications
    ↕
applications
```

---

# 9. Enquiry System

Ye e-commerce nahi hai.

User specific battery variant dekhkar enquiry karega.

Enquiry mein ideally information honi chahiye:

```text
variant_id
name
phone
email
company_name
message
source
status
timestamps
```

Status example:

```text
New
Read
Replied
Closed
```

Enquiry ko relevant **variant** ke saath properly relate karna.

Agar variant se enquiry aayi hai toh backend relationship ke through product/category identify ki ja sakti hai.

Historical data ke liye agar koi snapshot fields useful hon toh explain karna, lekin unnecessary duplicate data nahi rakhna.

---

# 10. WhatsApp Enquiry

WhatsApp ke liye kisi WhatsApp API ki requirement nahi hai.

Normal WhatsApp click-to-chat mechanism use karenge.

User jab kisi variant par:

```text
Enquire on WhatsApp
```

click karega toh message dynamically generate hoga.

Example:

```text
Hello Magnetic Power Battery,

I am interested in:

Product: LFP EV Battery
Variant: 48V 30Ah
SKU: LFP-48V-30AH

Please share more details.
```

WhatsApp number hardcoded nahi hona chahiye.

Number database/settings se aana chahiye.

---

# 11. Contact Messages

Contact page ke form ke liye separate table:

```text
contact_messages
```

Ismein:

```text
name
email
phone
subject
message
status
timestamps
```

jaisi fields honi chahiye.

Admin se messages manage/read/reply/close type workflow ho sakta hai.

---

# 12. Company Profile

About Us page ke liye company ka content database mein manage hona chahiye.

Company:

**Magnetic Power Battery**

About:

Magnetic Power Battery is a professional Lithium-ion Battery Manufacturer specializing in advanced LFP (Lithium Iron Phosphate) and NMC (Nickel Manganese Cobalt) battery technologies.

Company battery packs manufacture karti hai:

- Electric Vehicles
- E-Scooters
- E-Rickshaws
- Energy Storage Systems
- Other electric mobility applications

Company ka focus:

- Quality cells
- Advanced BMS technology
- Safety
- Durability
- Consistent performance

Vision:

**To become a trusted and innovative Lithium Battery Manufacturing Brand, supporting the rapid growth of electric mobility and clean energy solutions.**

Mission:

**To manufacture safe, reliable and technologically advanced battery solutions that help power the next generation of Electric Vehicles and Energy Storage Systems.**

Tagline:

**Powering Electric Mobility.  
Driving a Sustainable Future.**

Is content ko Blade mein hardcode karne ke bajaye company profile CMS se manage karna.

---

# 13. Production Director

Team member ke roop mein manage karna:

Name:

**Md. Alauddin**

Designation:

**Production Director**

Message:

“At Magnetic Power Battery, our focus is on maintaining the highest standards of quality, precision and reliability at every stage of production.

We are committed to building advanced LFP and NMC battery solutions through efficient manufacturing processes, strict quality control and continuous improvement. Every battery we produce represents our commitment to performance, safety and customer satisfaction.

Our goal is simple — to manufacture reliable energy solutions that power the future of electric mobility with confidence.

Quality in every cell. Reliability in every battery. Power for every journey.”

---

# 14. Managing Director

Team member ke roop mein manage karna:

Name:

**Mr. Amit Kumar**

Designation:

**Managing Director**

Message:

“At Magnetic Power Battery, our vision is to power the future of mobility with safe, reliable, high-performance and sustainable battery solutions.

We believe that the future of electric mobility depends not only on advanced technology, but also on quality, safety, reliability and customer trust. Our commitment is to develop and deliver innovative LFP and NMC battery solutions that meet the evolving needs of electric vehicles and energy applications.

Our mission is to contribute towards a cleaner and greener future by making dependable EV battery technology more accessible, efficient and reliable.

We don’t just manufacture batteries — we build the power behind the future of electric mobility.”

Ye team members table se manage hone chahiye.

Future mein aur directors/team members add ho sakein.

---

# 15. Soft Deletes

Important admin-managed entities mein Laravel SoftDeletes use karna.

Jaise:

```text
categories
brands
products
product_variants
product_images
variant_images
applications
team_members
faqs
banners
inquiries
contact_messages
```

Lekin har table mein blindly `deleted_at` add mat karna.

Pivot tables aur settings/configuration tables mein soft delete ka actual benefit hai ya nahi, woh explain karke decide karna.

---

# 16. Slugs

Public-facing entities ke liye proper slug system chahiye.

Example:

```text
LFP Batteries
↓
lfp-batteries
```

```text
LFP EV Battery
↓
lfp-ev-battery
```

```text
48V 30Ah Battery
↓
48v-30ah-battery
```

Proper unique indexes aur slug strategy explain karna.

---

# 17. Status aur Sorting

Admin-managed content mein jahan useful ho:

```text
is_active
sort_order
```

jaise fields rakhna.

Especially:

```text
Categories
Brands
Products
Variants
Applications
Banners
FAQs
Team Members
```

Admin website par decide kar sake ki kya active hai aur kis order mein show hoga.

---

# 18. Admin Panel

Admin panel:

**Laravel + Livewire + Tailwind CSS**

se banega.

Design:

- Clean
- Simple
- Professional
- Responsive
- Mobile friendly
- App-like on mobile

High-fi dashboard nahi banana.

Practical CMS banana hai.

Tailwind CSS ko properly use karna aur reusable UI components/classes maintain karna.

---

# 19. Responsive Admin Tables

Desktop par normal table:

```text
Product | Category | Brand | Status | Actions
```

Mobile par table ko force karke horizontal scrolling nahi karna wherever practical.

Mobile par card style:

```text
┌─────────────────────────┐
│ LFP EV Battery           │
│ Magnetic Power           │
│                          │
│ Active                   │
│                          │
│ Edit          More       │
└─────────────────────────┘
```

Filters desktop par:

```text
Search | Category | Brand | Status
```

Mobile par:

```text
Search

[ Filter ]
```

Filter click karne par Tailwind-based offcanvas/bottom-sheet type UI open ho sakta hai.

Admin panel properly:

```text
Desktop
Tablet
Mobile
```

teeno par responsive hona chahiye.

---

# 20. Admin Authentication

Laravel ka normal authentication use kar sakte hain.

Admin panel ka URL `/admin` rakhna compulsory nahi hai.

Koi sensible non-obvious route use kar sakte hain, for example:

```text
/control-center
```

Lekin ek important baat:

**Hidden/obscure URL ko security mechanism nahi samajhna.**

Actual security:

- Authentication
- Authorization
- CSRF
- Session security
- Strong password
- Rate limiting where required
- Proper middleware

se hogi.

Initially single admin ho sakta hai, lekin architecture future mein roles add karne ko allow kare.

---

# 21. Admin Navigation

Simple navigation:

```text
Dashboard

Catalog
 ├── Categories
 ├── Brands
 ├── Products
 ├── Variants
 └── Applications

Media
 ├── Product Images
 └── Variant Images

Inquiries
 ├── Product Enquiries
 └── Contact Messages

Website
 ├── Homepage
 ├── Banners
 ├── FAQs
 ├── Team Members
 └── Company Profile

Settings
 ├── General
 ├── Contact
 └── Social Links
```

Agar architecture ke according better navigation possible ho toh suggest karna, lekin unnecessary menu items mat banana.

---

# 22. Admin Dashboard

Dashboard simple aur useful hona chahiye.

Cards:

```text
Total Products
Total Variants
Total Categories
Total Brands
New Enquiries
Unread Contact Messages
```

Aur:

```text
Recent Enquiries
```

show kar sakte hain.

Dashboard ko unnecessarily complex nahi banana.

---

# 23. Development Process — VERY IMPORTANT

**Ek saath pura project ka code mat likhna.**

Hum step-by-step development karenge.

## STEP 1 — Database Architecture

Sabse pehle sirf database architecture finalize karna.

Is step mein:

- Tables
- Columns
- Data types
- Primary keys
- Foreign keys
- Relationships
- Indexes
- Unique constraints
- Nullable fields
- Default values
- Status strategy
- Soft delete strategy
- `onDelete` behavior
- Slug strategy

sab explain karna.

**Is step par migrations, models ya Livewire code mat likhna.**

---

## STEP 2 — Schema Review

STEP 1 ke baad mujhe complete schema dikhao.

Main review karunga.

Agar mujhe changes chahiye honge toh hum schema modify karenge.

**Meri confirmation ke bina next step par mat jaana.**

---

## STEP 3 — Models + Relationships

Schema finalize hone ke baad:

- Eloquent Models
- Relationships
- Casts
- Fillable/guarded strategy
- Useful scopes

implement karenge.

---

## STEP 4 — Migrations

Uske baad proper Laravel migrations:

- Foreign keys
- Indexes
- Unique constraints
- Soft deletes
- Nullable fields
- Proper `onDelete` behavior

ke saath banayenge.

---

## STEP 5 — Admin Authentication

Uske baad:

- Admin authentication
- Admin routes
- Middleware
- Admin user
- Basic seeders

setup karenge.

---

## STEP 6 — Admin Layout

Phir reusable Livewire/Blade admin layout:

- Sidebar
- Header
- Mobile navigation
- Flash messages
- Validation messages
- Buttons
- Modal
- Offcanvas
- Responsive table/card pattern

banayenge.

**Tailwind CSS use karna.**

---

## STEP 7 — CRUD Modules

CRUD dependency order mein banayenge:

```text
Categories
↓
Brands
↓
Applications
↓
Specifications
↓
Products
↓
Variants
↓
Product Images
↓
Variant Images
↓
Inquiries
↓
Contact Messages
↓
Company Profile
↓
Team Members
↓
Banners
↓
FAQs
↓
Settings
```

Har module complete hone ke baad next module par jaana.

Har CRUD mein relevant cheezein include karna:

```text
Create
Read/List
Edit
Delete
Soft Delete
Restore where required
Search
Filtering
Pagination
Validation
Status management
Responsive UI
Delete confirmation
```

---

# 24. STEP 8 — Dashboard

Core CRUD complete hone ke baad real database data ke saath admin dashboard banana.

---

# 25. STEP 9 — Public Website

Admin CMS properly complete hone ke baad hi public website banana.

Public website database se data consume karegi.

Business content ko unnecessarily Blade files mein duplicate nahi karna.

---

# 26. Coding Principles

Pure project mein:

1. Laravel conventions follow karna.
2. Proper Eloquent relationships use karna.
3. Database ko unnecessarily complicated nahi banana.
4. Duplicate data avoid karna.
5. Business content hardcode nahi karna.
6. Unnecessary packages install nahi karna.
7. Reusable Livewire components use karna.
8. Proper validation karna.
9. File uploads securely handle karna.
10. Proper database indexes use karna.
11. Multiple related DB operations ke liye zarurat padne par transactions use karna.
12. Admin authorization properly handle karna.
13. Public website aur admin panel ko logically separate rakhna.
14. React/Vue/Bootstrap introduce nahi karna.
15. Tailwind CSS ko project ki primary UI styling approach rakhna.
16. Existing architecture ko bina discussion ke change nahi karna.
17. "Scalable" ka matlab unnecessary over-engineering nahi hai.
18. Simple aur maintainable Laravel architecture ko priority dena.

---

# 27. ABHI TUMHARA FIRST TASK

**ABHI KOI CODE MAT LIKHNA.**

Migrations mat likhna.

Models mat likhna.

Livewire components mat likhna.

Controllers mat likhna.

Pehle requirements ko deeply analyze karo aur **complete database architecture proposal** do.

Har table ke liye explain karo:

- Table kyun chahiye
- Har column ka naam
- Data type
- Required ya nullable
- Default value
- Primary key
- Foreign key
- Indexes
- Unique constraints
- Relationships
- Soft delete chahiye ya nahi
- `onDelete` behavior

Uske baad complete ER-style relationship structure bhi dikhao.

**Sabse important: pehle database schema ko discuss aur finalize karenge.**

Main confirmation dunga tabhi hum STEP 2 se aage jayenge.

Hum pura project **step-by-step** build karenge, ek hi baar mein sab code generate nahi karna hai.