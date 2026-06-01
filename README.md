# Business Solutions Website

A modern, responsive 3-page website with an inquiry form and admin panel built with React, TypeScript, and Tailwind CSS.

## Features

### Pages
1. **Home Page** - Professional landing page with hero section, features, statistics, and call-to-action
2. **About Page** - Company story, mission, vision, values, and team information
3. **Contact Us Page** - Contact information and inquiry form with validation
4. **Admin Panel** - Database view to manage all inquiries

### Inquiry Form
- Full form validation
- Required fields: Name, Email, Phone, Subject, Message
- Email format validation
- Subject dropdown selection
- Success notification on submission
- Data stored in localStorage (simulating database)

### Admin Panel Features
- View all inquiries in a table format
- Filter by status (New, In Progress, Resolved)
- Update inquiry status
- View detailed inquiry information
- Delete individual inquiries
- Clear all inquiries
- Refresh data
- Responsive table design

## Technology Stack

- **React 18** - UI framework
- **TypeScript** - Type safety
- **Tailwind CSS** - Styling
- **Vite** - Build tool
- **Lucide React** - Icons
- **LocalStorage** - Data persistence (simulating database)

## Database Schema

While this demo uses localStorage, the `database_schema.sql` file contains the MySQL schema that would be used in a real PHP implementation:

```sql
CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'In Progress', 'Resolved') DEFAULT 'New',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Installation

```bash
# Install dependencies
npm install

# Run development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

## Usage

1. **Navigate the website** - Use the navigation menu to switch between pages
2. **Submit an inquiry** - Go to Contact Us page and fill out the form
3. **View inquiries** - Click "Admin Panel" in the footer to see all submissions
4. **Manage inquiries** - Update status, view details, or delete inquiries from the admin panel

## Converting to PHP

To convert this to a PHP application:

1. Use the `database_schema.sql` to create your MySQL database
2. Replace localStorage calls with PHP MySQL queries
3. Create PHP endpoints for:
   - `submit_inquiry.php` - Handle form submissions
   - `get_inquiries.php` - Fetch all inquiries
   - `update_inquiry.php` - Update inquiry status
   - `delete_inquiry.php` - Delete inquiries
4. Update the React app to make API calls to these endpoints instead of using localStorage

## Features Highlights

- ✅ Fully responsive design
- ✅ Mobile-friendly navigation
- ✅ Form validation
- ✅ Success notifications
- ✅ Data persistence
- ✅ Admin panel with CRUD operations
- ✅ Status management
- ✅ Professional UI/UX
- ✅ Accessibility features

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## License

MIT License - feel free to use this project for your own purposes.
