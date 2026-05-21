---
name: BuildBase
colors:
  surface: '#f7f9fb'
  surface-dim: '#d8dadc'
  surface-bright: '#f7f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#eceef0'
  surface-container-high: '#e6e8ea'
  surface-container-highest: '#e0e3e5'
  on-surface: '#191c1e'
  on-surface-variant: '#584237'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#8c7164'
  outline-variant: '#e0c0b1'
  surface-tint: '#9d4300'
  primary: '#9d4300'
  on-primary: '#ffffff'
  primary-container: '#f97316'
  on-primary-container: '#582200'
  inverse-primary: '#ffb690'
  secondary: '#515f74'
  on-secondary: '#ffffff'
  secondary-container: '#d5e3fd'
  on-secondary-container: '#57657b'
  tertiary: '#565e74'
  on-tertiary: '#ffffff'
  tertiary-container: '#929ab2'
  on-tertiary-container: '#2a3246'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdbca'
  primary-fixed-dim: '#ffb690'
  on-primary-fixed: '#341100'
  on-primary-fixed-variant: '#783200'
  secondary-fixed: '#d5e3fd'
  secondary-fixed-dim: '#b9c7e0'
  on-secondary-fixed: '#0d1c2f'
  on-secondary-fixed-variant: '#3a485c'
  tertiary-fixed: '#dae2fd'
  tertiary-fixed-dim: '#bec6e0'
  on-tertiary-fixed: '#131b2e'
  on-tertiary-fixed-variant: '#3f465c'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '800'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '700'
    lineHeight: 14px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  base: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  2xl: 48px
  3xl: 64px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 48px
---

## Brand & Style

The design system is engineered for the industrial construction and hardware sector. It prioritizes utility, durability, and precision, reflecting the professional-grade tools and materials it represents. The brand personality is rugged and dependable, moving away from consumer-grade softness toward a high-performance, institutional aesthetic.

The design style is a hybrid of **Minimalism** and **Modern Corporate**, utilizing heavy structural lines, significant whitespace for clarity in complex data, and a color-coded hierarchy. The UI should evoke the feeling of a blueprint or a well-organized job site: functional, high-contrast, and authoritative. Visual noise is eliminated to ensure that contractors and procurement officers can navigate inventory and logistics with maximum efficiency.

## Colors

The palette is rooted in industrial safety and structural integrity. 

- **Primary (Construction Orange):** Used exclusively for primary actions, critical status alerts, and branding accents. It serves as a visual "signal," ensuring key touchpoints are unmistakable.
- **Secondary (Slate Gray):** Provides the professional weight. Used for secondary buttons, iconography, and structural dividers.
- **Tertiary (Deep Navy/Ink):** Used for primary text and high-contrast headers to ensure maximum readability against white backgrounds.
- **Surface (White/Slate-50):** Surfaces are kept clean and clinical to allow product imagery and technical data to stand out.

Backgrounds use a very light cool gray (`#F8FAFC`) to reduce eye strain during prolonged use, while active workspaces use pure white (`#FFFFFF`) to denote focus areas.

## Typography

This design system utilizes **Inter** across all levels to maintain a systematic, utilitarian appearance. The typeface was chosen for its exceptional legibility in technical contexts and high x-height, which aids in reading long lists of hardware specifications.

- **Headlines:** Use tighter letter spacing and heavier weights (Bold/ExtraBold) to convey strength.
- **Labels:** Small labels and data headers use uppercase with slight letter spacing to mimic industrial stamping and signage.
- **Body:** Standardized at 16px for desktop to ensure accessibility on the shop floor or job site.

## Layout & Spacing

The layout follows a **Rigid Grid** philosophy. It uses a 12-column system for desktop and a 4-column system for mobile. 

- **Grid:** 24px gutters provide ample breathing room between dense information blocks. 
- **Rhythm:** All spacing is based on a 4px baseline grid. This "small-increment" approach allows for tight, data-dense layouts necessary for inventory management and technical spec sheets.
- **Adaptation:** On mobile, margins reduce to 16px, and complex data tables should collapse into "card-list" views. Sidebars for filtering are persistent on desktop but move to a full-screen drawer on mobile devices.

## Elevation & Depth

To maintain a professional/industrial feel, elevation is conveyed through **Tonal Layering** and **Low-Contrast Outlines** rather than soft shadows.

- **Levels:** Surfaces are differentiated by background color shifts (e.g., a Slate-50 background with White cards).
- **Outlines:** Use 1px solid borders in Slate-200 for most containers. This mimics the precision of technical drawings.
- **Active State Elevation:** Only "floating" elements like dropdowns or modals receive a shadow. This shadow should be sharp and high-density: `0px 4px 6px -1px rgba(0, 0, 0, 0.1), 0px 2px 4px -1px rgba(0, 0, 0, 0.06)`.
- **Dividers:** Use 1px lines in Slate-100 for internal sectioning.

## Shapes

The shape language is "Geometric Industrial." While sharp 0px corners can feel dated, a subtle **4px (0.25rem)** radius is applied to maintain a modern professional feel while remaining "hard-edged."

- **Buttons & Inputs:** 4px radius.
- **Cards & Modals:** 4px radius.
- **Icons:** Use square caps and joins; avoid rounded terminals to stay consistent with the hardware theme.
- **Status Pills:** Unlike other elements, these can use a pill-shape to distinguish them from interactive buttons.

## Components

- **Buttons:** 
    - *Primary:* Solid Construction Orange with White text. Bold weight.
    - *Secondary:* Solid Slate-700 with White text.
    - *Outline:* 1px Slate-300 border with Slate-700 text for low-priority actions.
- **Input Fields:** 
    - 1px Slate-300 border, 4px radius. 
    - Active state uses a 2px Construction Orange border. 
    - Labels are always persistent above the field in `label-sm` style.
- **Cards:** 
    - White background, 1px Slate-200 border. No shadow. 
    - Card headers should have a subtle Slate-50 background fill to separate them from the card body.
- **Data Tables:** 
    - The backbone of the system. 
    - Use zebra-striping (Slate-50) for readability in long rows. 
    - Hover states on rows should use a very faint Orange tint (#FFF7ED).
- **Chips/Badges:** 
    - Used for stock status (e.g., "In Stock", "Out of Stock"). 
    - Use square-ish proportions (4px radius) and high-contrast background fills.
- **Inventory Metrics:** 
    - Large-format numerical displays for SKU counts or pricing, using `headline-lg` in Slate-900.