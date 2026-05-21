# HamburgerMenu Component

## Overview

The `HamburgerMenu` component is a mobile navigation menu that slides from the top of the screen with a semi-transparent backdrop overlay. It provides a full-screen mobile navigation experience with keyboard navigation support and accessibility features.

## Features

- **Slide-from-top animation** (300ms ease-out) - Smooth entrance animation
- **Backdrop overlay** (rgba(0,0,0,0.5)) - Semi-transparent background to focus on menu
- **Close button** - Top-right corner close button with icon
- **Full-width menu items** - 48px height each for comfortable touch targets
- **Keyboard navigation** - Escape to close, Arrow keys to navigate, Home/End to jump
- **Accessibility** - ARIA labels, focus management, semantic HTML
- **Dark mode support** - Automatic dark mode styling with Tailwind
- **Body scroll prevention** - Prevents scrolling when menu is open

## Requirements

- **Requirement 1.4**: Mobile menu overlay that slides from top with backdrop
- **Requirement 9.2**: Mobile menu items with hover effects and keyboard navigation

## Usage

### Basic Usage

```vue
<template>
  <div>
    <!-- Hamburger button to toggle menu -->
    <button @click="isMenuOpen = !isMenuOpen">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- HamburgerMenu component -->
    <HamburgerMenu
      :isOpen="isMenuOpen"
      :items="menuItems"
      @close="isMenuOpen = false"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import HamburgerMenu from '@/Components/HamburgerMenu.vue'

const isMenuOpen = ref(false)

const menuItems = [
  { label: 'Beranda', route: 'home' },
  { label: 'Katalog Produk', route: 'product.index' },
  { label: 'Kalkulator Material', route: 'calculator.index' },
  { label: 'Tentang', route: 'about' },
  { label: 'Kontak', route: 'contact' },
]
</script>
```

### With Custom Items

```vue
<script setup>
const customMenuItems = [
  { label: 'Dashboard', route: 'dashboard' },
  { label: 'Profil', route: 'profile.edit' },
  { label: 'Logout', route: 'logout', method: 'post' },
  { label: 'External Link', href: 'https://example.com' },
]
</script>

<template>
  <HamburgerMenu
    :isOpen="isMenuOpen"
    :items="customMenuItems"
    @close="isMenuOpen = false"
  />
</template>
```

## Props

### `isOpen` (Boolean)
- **Default**: `false`
- **Description**: Controls whether the menu is visible or hidden

### `items` (Array)
- **Default**: Default menu items (Beranda, Katalog Produk, etc.)
- **Description**: Array of menu items to display
- **Item Structure**:
  ```javascript
  {
    label: 'Menu Item Label',      // Required: Display text
    route: 'route.name',            // Optional: Inertia route name
    href: '/path',                  // Optional: Direct URL (if no route)
    method: 'post'                  // Optional: HTTP method (default: 'get')
  }
  ```

## Events

### `close`
Emitted when the user closes the menu by:
- Clicking the close button
- Clicking the backdrop overlay
- Pressing the Escape key
- Clicking a menu item

### `open`
Emitted when the menu opens (can be used for analytics or logging)

## Keyboard Navigation

| Key | Action |
|-----|--------|
| `Escape` | Close the menu |
| `ArrowDown` | Focus next menu item |
| `ArrowUp` | Focus previous menu item |
| `Home` | Focus first menu item |
| `End` | Focus last menu item |

## Accessibility Features

- **ARIA Labels**: Navigation menu and close button have descriptive labels
- **Focus Management**: Keyboard navigation with visible focus indicators
- **Semantic HTML**: Proper use of `<nav>`, `<ul>`, `<li>`, and `role` attributes
- **Body Scroll Prevention**: Prevents background scrolling when menu is open
- **Backdrop Click**: Clicking outside the menu closes it
- **Keyboard Support**: Full keyboard navigation support

## Styling

The component uses Tailwind CSS classes for styling:

- **Background**: White (light mode) / Slate 900 (dark mode)
- **Menu Items**: 48px height, full width, with hover effects
- **Close Button**: 32x32px, positioned top-right
- **Backdrop**: Semi-transparent black (rgba(0,0,0,0.5))
- **Animations**: 300ms slide-from-top, 300ms backdrop fade

### Dark Mode

The component automatically adapts to dark mode:
- Background changes to `dark:bg-slate-900`
- Text changes to `dark:text-slate-200`
- Hover states use `dark:hover:bg-slate-800`
- Border changes to `dark:border-slate-800`

## Animation Details

### Menu Slide Animation
- **Duration**: 300ms
- **Easing**: ease-out
- **Direction**: From top (-translate-y-full to translate-y-0)

### Backdrop Fade Animation
- **Duration**: 300ms (enter), 200ms (leave)
- **Easing**: ease-out (enter), ease-in (leave)
- **Effect**: Opacity 0 to 1

## Integration with Navbar

To integrate with the existing Navbar component:

```vue
<script setup>
import { ref } from 'vue'
import Navbar from '@/Pages/User/components/Navbar.vue'
import HamburgerMenu from '@/Components/HamburgerMenu.vue'

const isMenuOpen = ref(false)
</script>

<template>
  <div>
    <Navbar @hamburger-click="isMenuOpen = true" />
    <HamburgerMenu
      :isOpen="isMenuOpen"
      @close="isMenuOpen = false"
    />
  </div>
</template>
```

## Browser Support

- Chrome/Edge: Full support
- Firefox: Full support
- Safari: Full support
- Mobile browsers: Full support (optimized for touch)

## Performance Considerations

- Uses CSS transitions for smooth animations
- Prevents body scroll with `overflow: hidden` when menu is open
- Efficient event listener management with proper cleanup
- Minimal re-renders with Vue 3 reactivity

## Testing

The component includes comprehensive unit tests covering:
- Rendering and visibility
- Open/close interactions
- Keyboard navigation
- Accessibility features
- Animation behavior
- Custom menu items

Run tests with:
```bash
npm run test -- HamburgerMenu.test.ts --run
```

## Requirements Mapping

| Requirement | Implementation |
|-------------|-----------------|
| 1.4 | Mobile menu overlay with slide-from-top animation and backdrop |
| 9.2 | Full-width menu items with hover effects and keyboard navigation |
| 8.10 | Accessibility compliance with ARIA labels and focus management |

## Related Components

- **Navbar**: Main navigation component that triggers the hamburger menu
- **PkButton**: Button component used for close button
- **Link**: Inertia Link component for menu item navigation
