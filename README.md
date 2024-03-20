

```markdown
# Project Name

## Clone Laravel Project:

Follow these steps to clone and set up the Laravel project:

1. **Clone the Laravel project repository:**
   ```bash
   git clone https://github.com/HannaKamil/hotels-api.git
   ```

2. **Navigate to the project directory:**
   ```bash
   cd <project_directory>
   ```

3. **Install project dependencies:**
   ```bash
   composer install
   ```

4. **Copy the `.env.example` file to `.env`:**
   ```bash
   cp .env.example .env
   or
   copy .env.example .env  (Windows)
   ```

5. **Generate an application key:**
   ```bash
   php artisan key:generate
   ```

## Search Hotels:

To search for hotels with specific criteria, use the following endpoint:

- **GET** http://localhost:8000/api/hotels

**Query Parameters:**
- `hotel_name`: Hotel name (optional)
- `city`: Destination city (optional)
- `price_range`: Price range (optional)
- `date_range`: Date range (optional)
- `sort_by`: Sorting criteria (optional, default: name)
- `sort_order`: Sorting order (optional, default: asc)

**Example:**
http://localhost:8000/api/hotels?hotel_name=Hotel&city=dubai&price_range=100:200&date_range=2023-10-10:2023-10-15

## Sort Hotels:

To sort hotels by name or price in ascending or descending order, use the following endpoints:

- **Sort by name (descending):**
    - **GET** http://localhost:8000/api/hotels?sort_by=name&sort_order=desc

- **Sort by price (descending):**
    - **GET** http://localhost:8000/api/hotels?sort_by=price&sort_order=desc

## Run Tests:

Execute PHPUnit tests to ensure the functionality is working correctly:
```bash
php artisan test tests/Feature/Tests/Unit/HotelControllerTest.php
```
