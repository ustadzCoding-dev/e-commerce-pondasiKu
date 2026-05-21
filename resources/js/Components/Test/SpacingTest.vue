<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-6">Spacing System Test</h1>
    
    <div class="mb-8">
      <h2 class="text-xl font-semibold mb-4">Spacing Scale (8px base unit)</h2>
      <div class="space-y-4">
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">xs (4px)</div>
          <div class="h-4 bg-blue-200" :style="{ width: '4px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-xs, m-xs, gap-xs</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">sm (8px)</div>
          <div class="h-4 bg-blue-300" :style="{ width: '8px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-sm, m-sm, gap-sm</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">md (12px)</div>
          <div class="h-4 bg-blue-400" :style="{ width: '12px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-md, m-md, gap-md</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">lg (16px)</div>
          <div class="h-4 bg-blue-500" :style="{ width: '16px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-lg, m-lg, gap-lg</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">xl (24px)</div>
          <div class="h-4 bg-blue-600" :style="{ width: '24px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-xl, m-xl, gap-xl</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">2xl (32px)</div>
          <div class="h-4 bg-blue-700" :style="{ width: '32px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-2xl, m-2xl, gap-2xl</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">3xl (40px)</div>
          <div class="h-4 bg-blue-800" :style="{ width: '40px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-3xl, m-3xl, gap-3xl</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">4xl (48px)</div>
          <div class="h-4 bg-blue-900" :style="{ width: '48px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-4xl, m-4xl, gap-4xl</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">5xl (56px)</div>
          <div class="h-4 bg-indigo-600" :style="{ width: '56px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-5xl, m-5xl, gap-5xl</div>
        </div>
        <div class="flex items-center">
          <div class="w-20 text-sm font-medium">6xl (64px)</div>
          <div class="h-4 bg-indigo-800" :style="{ width: '64px' }"></div>
          <div class="ml-2 text-sm text-gray-600">class: p-6xl, m-6xl, gap-6xl</div>
        </div>
      </div>
    </div>

    <div class="mb-8">
      <h2 class="text-xl font-semibold mb-4">Responsive Padding Utilities</h2>
      <div class="space-y-4">
        <div class="p-padding-mobile md:p-padding-tablet lg:p-padding-desktop bg-green-50 border border-green-200 rounded-lg">
          <div class="font-medium">Responsive Padding Example</div>
          <div class="text-sm text-gray-600">
            This element has responsive padding:
            <ul class="mt-2 space-y-1">
              <li>• Mobile (&lt;640px): p-padding-mobile (16px)</li>
              <li>• Tablet (640px-1024px): p-padding-tablet (24px)</li>
              <li>• Desktop (&gt;1024px): p-padding-desktop (32px)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-8">
      <h2 class="text-xl font-semibold mb-4">Section Spacing</h2>
      <div class="space-y-6">
        <div class="p-section-horizontal-mobile md:p-section-horizontal-tablet lg:p-section-horizontal-desktop 
                    py-section-vertical-mobile md:py-section-vertical-tablet lg:py-section-vertical-desktop 
                    bg-amber-50 border border-amber-200 rounded-lg">
          <div class="font-medium">Section Spacing Example</div>
          <div class="text-sm text-gray-600">
            This simulates a section with responsive spacing:
            <ul class="mt-2 space-y-1">
              <li>• Horizontal padding: 16px (mobile) → 24px (tablet) → 32px (desktop)</li>
              <li>• Vertical padding: 40px (mobile) → 56px (tablet) → 64px (desktop)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-8">
      <h2 class="text-xl font-semibold mb-4">Breakpoint Test</h2>
      <div class="space-y-4">
        <div class="p-4 bg-gray-100 rounded-lg">
          <div class="font-medium">Current Breakpoint:</div>
          <div class="text-sm">
            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded mobile:block tablet:hidden desktop:hidden">Mobile (&lt;640px)</span>
            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded mobile:hidden tablet:block desktop:hidden">Tablet (640px-1024px)</span>
            <span class="inline-block px-2 py-1 bg-purple-100 text-purple-800 rounded mobile:hidden tablet:hidden desktop:block">Desktop (&gt;1024px)</span>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-8">
      <h2 class="text-xl font-semibold mb-4">Spacing Usage Examples</h2>
      <div class="space-y-6">
        <div class="p-lg border border-gray-200 rounded-lg">
          <div class="font-medium">Card with consistent spacing</div>
          <div class="mt-md text-sm text-gray-600">
            This card uses p-lg (16px) for padding and mt-md (12px) for margin-top.
          </div>
          <div class="mt-lg flex gap-md">
            <button class="px-xl py-sm bg-blue-500 text-white rounded-md">Button 1</button>
            <button class="px-xl py-sm bg-gray-200 text-gray-800 rounded-md">Button 2</button>
          </div>
        </div>

        <div class="p-xl border border-gray-200 rounded-lg">
          <div class="font-medium">Form with consistent spacing</div>
          <div class="space-y-md">
            <div>
              <label class="block text-sm font-medium mb-xs">Email</label>
              <input type="email" class="w-full p-sm border border-gray-300 rounded-md" placeholder="test@example.com">
            </div>
            <div>
              <label class="block text-sm font-medium mb-xs">Password</label>
              <input type="password" class="w-full p-sm border border-gray-300 rounded-md" placeholder="••••••••">
            </div>
            <button class="w-full p-sm bg-green-500 text-white rounded-md">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// This component demonstrates the spacing system
</script>

<style scoped>
/* Additional styles if needed */
</style>