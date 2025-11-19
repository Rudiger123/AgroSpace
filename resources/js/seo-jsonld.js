/* AgroSpace JSON-LD – sans @, sans Blade, 100 % JS */
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
        "name": "Accueil - AgroSpace",
        "description": "Plateforme de connexion entre producteurs et consommateurs agricoles au Cameroun",
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
            }, {
                "@type": "Question",
                "name": "Est-ce que l'inscription sur AgroSpace est gratuite ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Oui, l'inscription sur AgroSpace est 100% gratuite pour les producteurs comme pour les consommateurs. Aucune carte bancaire n'est requise et vous bénéficiez d'un accès complet aux fonctionnalités de la plateforme."
                }
            }, {
                "@type": "Question",
                "name": "Qui peut utiliser AgroSpace ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "AgroSpace s'adresse aux producteurs agricoles (agriculteurs, éleveurs, coopératives), aux consommateurs (restaurateurs, commerçants, particuliers) et à tous les acteurs de la chaîne de valeur agricole au Cameroun."
                }
            }, {
                "@type": "Question",
                "name": "Dans quelles régions du Cameroun AgroSpace est-il disponible ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "AgroSpace est disponible dans toutes les régions du Cameroun : Littoral, Centre, Ouest, Nord, Extrême-Nord, Adamaoua, Est, Sud et Sud-Ouest. Nous connectons producteurs et consommateurs à travers tout le pays."
                }
            },

            {
                "@type": "Question",
                "name": "Comment publier une offre sur AgroSpace ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Rendez-vous dans votre tableau de bord, cliquez sur « Publier une offre », ajoutez vos photos, description, prix et région, puis validez. Votre offre est immédiatement visible."
                }
            },
            {
                "@type": "Question",
                "name": "La messagerie est-elle sécurisée ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Oui, toutes les conversations sont chiffrées et restent privées entre les membres. Aucun tiers ne peut y accéder."
                }
            },
            {
                "@type": "Question",
                "name": "Quelle est la mission d’AgroSpace ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Faciliter les échanges entre acteurs agricoles et valoriser la production locale grâce au numérique."
                }
            },
            {
                "@type": "Question",
                "name": "Qui peut rejoindre la plateforme ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Tout producteur, consommateur ou acteur de la chaîne de valeur agricole au Cameroun."
                }
            },
            {
                "@type": "Question",
                "name": "L'inscription en tant que producteur est-elle gratuite ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Oui, l'inscription sur AgroSpace est 100% gratuite pour les producteurs. Aucune commission n'est prélevée sur vos ventes."
                }
            },
            {
                "@type": "Question",
                "name": "Puis-je publier autant d'offres que je veux ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Absolument. Vous pouvez publier un nombre illimité d'offres sur la plateforme, que ce soit pour des produits ou des services agricoles."
                }
            }
        ]
    }

    /* Injection dans le <head> */
    [org, webSite, webPage].forEach(data => {
        const script = document.createElement('script');
        script.type = 'application/ld+json';
        script.textContent = JSON.stringify(data);
        document.head.appendChild(script);
    });
})();