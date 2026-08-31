import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {

    // ==========================================
    // 1. LENIS SMOOTH SCROLL
    // ==========================================
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smooth: true,
        smoothTouch: false,
        touchMultiplier: 2,
    });

    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => { lenis.raf(time * 1000); });
    gsap.ticker.lagSmoothing(0);

    // ==========================================
    // 2. MOBILE MENU
    // ==========================================
    const menuBtn = document.getElementById('mobile-menu-btn');
    const menuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
            mobileMenu.classList.add('opacity-100', 'pointer-events-auto');
        });
    }
    if (menuClose && mobileMenu) {
        menuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('opacity-100', 'pointer-events-auto');
            mobileMenu.classList.add('opacity-0', 'pointer-events-none');
        });
        // Close on link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('opacity-100', 'pointer-events-auto');
                mobileMenu.classList.add('opacity-0', 'pointer-events-none');
            });
        });
    }



    // ==========================================
    // 4. HEADER SCROLL EFFECT
    // ==========================================
    gsap.to("#main-header", {
        scrollTrigger: {
            trigger: "body",
            start: "80px top",
            toggleActions: "play none none reverse",
        },
        backgroundColor: "rgba(0, 0, 0, 0.85)",
        backdropFilter: "blur(12px)",
        duration: 0.3
    });

    // ==========================================
    // 5. HERO ANIMATIONS
    // ==========================================
    if (document.getElementById('scene-hero')) {
        // Intro animation
        const introTl = gsap.timeline({ delay: 0.3 });
        introTl.to(".fade-up", {
            opacity: 1,
            y: 0,
            duration: 1,
            stagger: 0.12,
            ease: "power3.out"
        });

        // Hero scroll parallax
        const heroTl = gsap.timeline({
            scrollTrigger: {
                trigger: "#scene-hero",
                start: "top top",
                end: "bottom top",
                scrub: 1,
            }
        });

        heroTl.to("#hero-battery-img", { scale: 1.8, opacity: 0, ease: "none" }, 0);
        heroTl.to("#hero-text-block", { yPercent: -30, opacity: 0, ease: "none" }, 0);
    }

    // ==========================================
    // 7. RANGE / KM DRIVING SCENE
    // ==========================================
    if (document.getElementById('range-sequence-wrapper')) {
        const rangeTl = gsap.timeline({
            scrollTrigger: {
                trigger: "#range-sequence-wrapper",
                start: "top top",
                end: "bottom bottom",
                scrub: 1,
            }
        });

        // Road dashes move to simulate driving forward
        rangeTl.to("#road-dashes", {
            backgroundPosition: "0% 2000%",
            ease: "none",
            duration: 10
        }, 0);

        // Scooter subtle bounce (riding feel)
        if (document.getElementById('scooter-rider')) {
            rangeTl.to("#scooter-rider", {
                y: -5,
                duration: 0.3,
                yoyo: true,
                repeat: 30,
                ease: "sine.inOut"
            }, 0);
        }

        // Scooter glow changes from green to red as battery depletes
        rangeTl.to("#scooter-glow", {
            backgroundColor: "rgba(239, 68, 68, 0.4)",
            ease: "none",
            duration: 10
        }, 0);

        // Speed ramps up then down
        const speedEl = document.getElementById('speed-display');
        if (speedEl) {
            rangeTl.to({ val: 0 }, {
                val: 65,
                duration: 4,
                ease: "power2.out",
                onUpdate: function() { speedEl.textContent = Math.round(this.targets()[0].val); }
            }, 0);
            rangeTl.to({ val: 65 }, {
                val: 45,
                duration: 6,
                ease: "power1.inOut",
                onUpdate: function() { speedEl.textContent = Math.round(this.targets()[0].val); }
            }, 4);
        }

        // Distance goes up
        const distEl = document.getElementById('distance-number');
        if (distEl) {
            rangeTl.to({ val: 0 }, {
                val: 150,
                duration: 10,
                ease: "none",
                onUpdate: function() { distEl.textContent = Math.round(this.targets()[0].val); }
            }, 0);
        }

        // Battery depletes
        const battEl = document.getElementById('battery-percent');
        if (battEl) {
            rangeTl.to({ val: 100 }, {
                val: 12,
                duration: 10,
                ease: "none",
                onUpdate: function() { battEl.textContent = Math.round(this.targets()[0].val); }
            }, 0);
        }

        // Battery bar shrinks and changes color
        rangeTl.to("#battery-indicator", {
            width: "12%",
            backgroundColor: "#ef4444",
            boxShadow: "0 0 10px #ef4444",
            ease: "none",
            duration: 10
        }, 0);
    }

    // ==========================================
    // 6. BATTERY EXPLOSION SEQUENCE
    // ==========================================
    // ==========================================
    // SIMPLE COUNTER ANIMATION
    // ==========================================
    const statsSection = document.getElementById('scene-perf');
    if (statsSection) {
        ScrollTrigger.create({
            trigger: "#scene-perf",
            start: "top 80%",
            onEnter: () => {
                document.querySelectorAll('.counter').forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    gsap.to(counter, {
                        innerHTML: target,
                        duration: 2,
                        snap: { innerHTML: 1 },
                        ease: "power2.out"
                    });
                });
            },
            once: true
        });
    }

    // ==========================================
    // 9. GLOBAL FADE-UP OBSERVER
    // ==========================================
    document.querySelectorAll('.fade-up').forEach((el) => {
        // Skip hero elements (those are handled by the intro timeline)
        if (el.closest('#scene-hero')) return;
        
        gsap.fromTo(el,
            { opacity: 0, y: 40 },
            {
                opacity: 1, y: 0,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top 88%",
                    toggleActions: "play none none none"
                }
            }
        );
    });

});
