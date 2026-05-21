# Skeleton Component

Loading placeholder component with shimmer animation for better perceived performance.

**Requirement Reference:** REQ-10 (Loading States dan Skeleton Indicators)

## Features

- ✅ Shimmer animation with CSS keyframes
- ✅ Three variants: text, circle, rectangle
- ✅ Three size presets: sm, md, lg
- ✅ Custom width and height support
- ✅ Multiple skeletons with count prop
- ✅ Dark mode support
- ✅ Accessibility features (ARIA labels, reduced motion support)

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | String | `'text'` | Shape variant: `text`, `circle`, or `rectangle` |
| `size` | String | `'md'` | Size preset: `sm`, `md`, or `lg` |
| `width` | String | `null` | Custom width (CSS value) - overrides size preset |
| `height` | String | `null` | Custom height (CSS value) - overrides size preset |
| `count` | Number | `1` | Number of skeleton items to render |
| `gap` | String | `'8px'` | Gap between multiple skeletons (CSS value) |

## Size Presets

### Text Variant
- **sm**: 100% width × 12px height
- **md**: 100% width × 16px height
- **lg**: 100% width × 24px height

### Circle Variant
- **sm**: 32px × 32px
- **md**: 40px × 40px
- **lg**: 64px × 64px

### Rectangle Variant
- **sm**: 100% width × 80px height
- **md**: 100% width × 120px height
- **lg**: 100% width × 200px height

## Usage Examples

### Basic Text Skeleton

```vue
<template>
  <Skeleton variant="text" />
</template>

<script setup>
import Skeleton from '@/Components/Skeleton.vue';
</script>
```

### Multiple Text Lines

```vue
<Skeleton variant="text" :count="3" />
```

### Circle Avatar Skeleton

```vue
<Skeleton variant="circle" size="lg" />
```

### Rectangle Image Skeleton

```vue
<Skeleton variant="rectangle" size="md" />
```

### Custom Dimensions

```vue
<Skeleton variant="rectangle" width="300px" height="150px" />
```

### Product Card Skeleton

```vue
<template>
  <div class="product-card">
    <!-- Product Image -->
    <Skeleton variant="rectangle" height="200px" />
    
    <!-- Brand -->
    <Skeleton variant="text" size="sm" width="40%" />
    
    <!-- Product Title (2 lines) -->
    <Skeleton variant="text" size="md" :count="2" gap="8px" />
    
    <!-- Price -->
    <Skeleton variant="text" size="lg" width="60%" />
  </div>
</template>
```

### Product Grid Skeleton

```vue
<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div v-for="i in 4" :key="i" class="border rounded-xl p-5">
      <Skeleton variant="rectangle" height="200px" />
      <Skeleton variant="text" size="sm" width="40%" class="mt-4" />
      <Skeleton variant="text" :count="2" gap="8px" class="mt-2" />
      <Skeleton variant="text" size="lg" width="60%" class="mt-3" />
    </div>
  </div>
</template>
```

### Dashboard Statistics Card Skeleton

```vue
<template>
  <div class="stats-card flex items-center gap-4">
    <!-- Icon -->
    <Skeleton variant="circle" size="lg" />
    
    <!-- Content -->
    <div class="flex-1">
      <Skeleton variant="text" size="sm" width="60%" />
      <Skeleton variant="text" size="lg" width="40%" class="mt-2" />
    </div>
  </div>
</template>
```

### Table Skeleton

```vue
<template>
  <div class="table-container">
    <!-- Table Header -->
    <div class="table-header">
      <div class="grid grid-cols-5 gap-4">
        <Skeleton variant="text" size="sm" width="80%" />
        <Skeleton variant="text" size="sm" width="80%" />
        <Skeleton variant="text" size="sm" width="80%" />
        <Skeleton variant="text" size="sm" width="80%" />
        <Skeleton variant="text" size="sm" width="80%" />
      </div>
    </div>
    
    <!-- Table Rows -->
    <div v-for="i in 5" :key="i" class="table-row">
      <div class="grid grid-cols-5 gap-4">
        <Skeleton variant="text" size="md" width="90%" />
        <Skeleton variant="text" size="md" width="70%" />
        <Skeleton variant="text" size="md" width="60%" />
        <Skeleton variant="text" size="sm" width="50%" />
        <Skeleton variant="rectangle" height="32px" width="80px" />
      </div>
    </div>
  </div>
</template>
```

### Cart Page Skeleton

```vue
<template>
  <div class="cart-page">
    <!-- Cart Items -->
    <div class="cart-items">
      <div v-for="i in 3" :key="i" class="cart-item">
        <Skeleton variant="rectangle" width="112px" height="112px" />
        <div class="flex-1">
          <Skeleton variant="text" size="lg" width="70%" />
          <Skeleton variant="text" size="sm" width="40%" class="mt-2" />
          <Skeleton variant="text" size="md" width="50%" class="mt-2" />
        </div>
      </div>
    </div>
    
    <!-- Invoice Summary -->
    <div class="invoice-summary">
      <Skeleton variant="text" :count="5" gap="16px" />
      <Skeleton variant="rectangle" height="48px" class="mt-6" />
    </div>
  </div>
</template>
```

## Dark Mode

The Skeleton component automatically adapts to dark mode:

- **Light mode**: Uses Slate 200 (#e2e8f0) and Slate 100 (#f1f5f9) for shimmer
- **Dark mode**: Uses Slate 800 (#1e293b) and Slate 700 (#334155) for shimmer

No additional configuration needed - it responds to the `.dark` class on parent elements.

## Accessibility

The component includes several accessibility features:

1. **ARIA Labels**: Each skeleton has `role="status"` and `aria-label="Loading..."` for screen readers
2. **Reduced Motion**: Respects `prefers-reduced-motion` media query - disables animation for users who prefer reduced motion
3. **Semantic HTML**: Uses proper semantic structure for better screen reader support

## Animation Details

The shimmer animation uses CSS keyframes:

- **Duration**: 2 seconds
- **Timing**: Linear (continuous)
- **Direction**: Left to right
- **Gradient**: 3-color gradient (start → middle → end)
- **Background size**: 1000px width for smooth animation

## Browser Support

Works in all modern browsers that support:
- CSS animations
- CSS gradients
- CSS custom properties (for dark mode)

## Performance

- Uses CSS animations (GPU-accelerated)
- No JavaScript animations
- Minimal DOM manipulation
- Efficient rendering with Vue 3 composition API

## Testing

A comprehensive test file is available at `resources/js/Components/Test/SkeletonTest.vue` that demonstrates:

- All variants (text, circle, rectangle)
- All sizes (sm, md, lg)
- Custom dimensions
- Multiple skeletons
- Real-world examples (product cards, tables, statistics)
- Dark mode support
