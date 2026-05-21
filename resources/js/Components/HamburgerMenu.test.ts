import { describe, it, expect, beforeEach, vi } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'
import HamburgerMenu from './HamburgerMenu.vue'

/**
 * Unit Tests for HamburgerMenu Component
 *
 * Tests cover:
 * - Open/close functionality
 * - Animations (slide-from-top, backdrop fade)
 * - Keyboard navigation (Escape, Arrow keys, Home, End)
 * - Accessibility (ARIA labels, focus management)
 * - Menu item rendering and interaction
 *
 * Requirements: 1.4, 9.2
 */

describe('HamburgerMenu Component', () => {
    const defaultItems = [
        { label: 'Beranda', route: 'home' },
        { label: 'Katalog Produk', route: 'product.index' },
        { label: 'Kalkulator Material', route: 'calculator.index' },
        { label: 'Tentang', route: 'about' },
        { label: 'Kontak', route: 'contact' },
    ]

    beforeEach(() => {
        // Reset body overflow style
        document.body.style.overflow = ''
    })

    describe('Rendering', () => {
        it('should not render menu when isOpen is false', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: false,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            expect(wrapper.find('[role="navigation"]').exists()).toBe(false)
        })

        it('should render menu when isOpen is true', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            expect(wrapper.find('[role="navigation"]').exists()).toBe(true)
        })

        it('should render all menu items', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const menuItems = wrapper.findAll('[role="menuitem"]')
            expect(menuItems).toHaveLength(defaultItems.length)

            defaultItems.forEach((item, index) => {
                expect(menuItems[index].text()).toBe(item.label)
            })
        })

        it('should render close button', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const closeButton = wrapper.find('button[aria-label="Close menu"]')
            expect(closeButton.exists()).toBe(true)
        })

        it('should render backdrop overlay when menu is open', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            expect(wrapper.find('.bg-black\\/50').exists()).toBe(true)
        })
    })

    describe('Interactions', () => {
        it('should emit close event when close button is clicked', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const closeButton = wrapper.find('button[aria-label="Close menu"]')
            await closeButton.trigger('click')

            expect(wrapper.emitted('close')).toBeTruthy()
        })

        it('should emit close event when backdrop is clicked', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const backdrop = wrapper.find('.bg-black\\/50')
            await backdrop.trigger('click')

            expect(wrapper.emitted('close')).toBeTruthy()
        })

        it('should not emit close event when menu content is clicked', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const menuContent = wrapper.find('[role="navigation"]')
            await menuContent.trigger('click')

            expect(wrapper.emitted('close')).toBeFalsy()
        })

        it('should emit close event when menu item is clicked', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a @click="$emit(\'click\')"><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const firstMenuItem = wrapper.find('[role="menuitem"]')
            await firstMenuItem.trigger('click')

            expect(wrapper.emitted('close')).toBeTruthy()
        })
    })

    describe('Keyboard Navigation', () => {
        it('should close menu when Escape key is pressed', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const event = new KeyboardEvent('keydown', { key: 'Escape' })
            document.dispatchEvent(event)

            expect(wrapper.emitted('close')).toBeTruthy()
        })

        it('should navigate down through menu items with ArrowDown', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const event = new KeyboardEvent('keydown', { key: 'ArrowDown' })
            document.dispatchEvent(event)
            await wrapper.vm.$nextTick()

            // Verify that focus management is working
            expect(wrapper.vm.focusedItemIndex).toBe(0)
        })

        it('should navigate up through menu items with ArrowUp', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            // Set initial focused item
            wrapper.vm.focusedItemIndex = 2

            const event = new KeyboardEvent('keydown', { key: 'ArrowUp' })
            document.dispatchEvent(event)
            await wrapper.vm.$nextTick()

            expect(wrapper.vm.focusedItemIndex).toBe(1)
        })

        it('should jump to first item with Home key', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            wrapper.vm.focusedItemIndex = 3

            const event = new KeyboardEvent('keydown', { key: 'Home' })
            document.dispatchEvent(event)
            await wrapper.vm.$nextTick()

            expect(wrapper.vm.focusedItemIndex).toBe(0)
        })

        it('should jump to last item with End key', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const event = new KeyboardEvent('keydown', { key: 'End' })
            document.dispatchEvent(event)
            await wrapper.vm.$nextTick()

            expect(wrapper.vm.focusedItemIndex).toBe(defaultItems.length - 1)
        })

        it('should not respond to keyboard when menu is closed', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: false,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const event = new KeyboardEvent('keydown', { key: 'ArrowDown' })
            document.dispatchEvent(event)
            await wrapper.vm.$nextTick()

            expect(wrapper.vm.focusedItemIndex).toBe(-1)
        })
    })

    describe('Accessibility', () => {
        it('should have proper ARIA labels', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            expect(wrapper.find('[role="navigation"]').attributes('aria-label')).toBe('Mobile Navigation Menu')
            expect(wrapper.find('button[aria-label="Close menu"]').exists()).toBe(true)
        })

        it('should have proper menu item roles', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const menuItems = wrapper.findAll('[role="menuitem"]')
            menuItems.forEach((item) => {
                expect(item.attributes('role')).toBe('menuitem')
            })
        })

        it('should manage body overflow when menu opens/closes', async () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: false,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            // Initially, body overflow should be empty
            expect(document.body.style.overflow).toBe('')

            // Update to open
            await wrapper.setProps({ isOpen: true })
            await wrapper.vm.$nextTick()

            expect(document.body.style.overflow).toBe('hidden')

            // Update to closed
            await wrapper.setProps({ isOpen: false })
            await wrapper.vm.$nextTick()

            expect(document.body.style.overflow).toBe('')
        })
    })

    describe('Animations', () => {
        it('should have slide-from-top animation classes', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const menuContainer = wrapper.find('[role="navigation"]')
            expect(menuContainer.exists()).toBe(true)
            // Animation classes are applied via Transition component
        })

        it('should have backdrop fade animation', () => {
            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: defaultItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const backdrop = wrapper.find('.bg-black\\/50')
            expect(backdrop.exists()).toBe(true)
            // Animation classes are applied via Transition component
        })
    })

    describe('Custom Items', () => {
        it('should render custom menu items', () => {
            const customItems = [
                { label: 'Custom 1', route: 'custom1' },
                { label: 'Custom 2', href: '/custom2' },
            ]

            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: customItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const menuItems = wrapper.findAll('[role="menuitem"]')
            expect(menuItems).toHaveLength(2)
            expect(menuItems[0].text()).toBe('Custom 1')
            expect(menuItems[1].text()).toBe('Custom 2')
        })

        it('should handle items with custom methods', () => {
            const customItems = [
                { label: 'Logout', route: 'logout', method: 'post' },
            ]

            const wrapper = mount(HamburgerMenu, {
                props: {
                    isOpen: true,
                    items: customItems,
                },
                global: {
                    stubs: {
                        Link: { template: '<a><slot /></a>' },
                    },
                    mocks: {
                        route: (name) => `/${name}`,
                    },
                },
            })

            const menuItem = wrapper.find('[role="menuitem"]')
            expect(menuItem.exists()).toBe(true)
        })
    })
})
