/* =========================================================
   AgroSpace – JSON-LD  (sans @, sans Blade, 100 % JS)
   ========================================================= */
(function injectJsonLd() {
    /* 1 – Organisation */
    const org = {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "AgroSpace",
        "alternateName": "AgroSpace Cameroun",
        "url": window.location.origin,
        "logo": `${window.location.origin}/images/logo.png`,
        "description": "Plateforme de connexion entre producteurs et consommateurs agricoles au Cameroun",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "CM",
            "addressRegion": "Littoral",
            "addressLocality": "Douala"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+237-XXX-XXX-XXX",
            "contactType": "Customer Service",
            "areaServed": "CM",
            "availableLanguage": ["fr"]
        },
        "sameAs": [
            "https://facebook.com/agrospace",
            "https://twitter.com/agrospace",
            "https://linkedin.com/company/agrospace"
        ]
    };

    /* 2 – WebSite (avec SearchBox) */
    const webSite = {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "AgroSpace",
        "url": window.location.origin,
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": `${window.location.origin}/search?q={search_term_string}`
            },
            "query-input": "required name=search_term_string"
        }
    };

    /* 3 – WebPage courant (breadcrumb + étoiles) */
    const webPage = {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": document.title || "Accueil - AgroSpace",
        "description": document.querySelector('meta[name="description"]') ||
            "Plateforme de connexion entre producteurs et consommateurs agricoles au Cameroun",
        "url": window.location.href,
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "Accueil",
                "item": window.location.origin
            }]
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "reviewCount": "2847",
            "bestRating": "5",
            "worstRating": "1"
        }
    };

    /* 4 – FAQ */
    const faq = {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [{
                "@type": "Question",
                "name": "Comment fonctionne AgroSpace ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "AgroSpace est une plateforme qui connecte producteurs et consommateurs agricoles au Cameroun. Inscrivez-vous gratuitement, créez votre profil, publiez vos offres ou demandes, puis échangez directement avec d'autres membres via la messagerie intégrée."
                }
            },
            {
                "@type": "Question",
                "name": "Est-ce que l'inscription sur AgroSpace est gratuite ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Oui, l'inscription sur AgroSpace est 100 % gratuite pour les producteurs comme pour les consommateurs. Aucune carte bancaire n'est requise et vous bénéficiez d'un accès complet aux fonctionnalités de la plateforme."
                }
            }
        ]
    };

    /* Injection sécurisée dans le <head> */
    [org, webSite, webPage, faq].forEach(data => {
        const script = document.createElement('script');
        script.type = 'application/ld+json';
        script.textContent = JSON.stringify(data);
        document.head.appendChild(script);
    });
})();