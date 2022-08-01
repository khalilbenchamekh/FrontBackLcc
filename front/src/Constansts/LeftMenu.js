export const Links = [
    {
        name: "Dashboard",
        url: "/dashboard",
    }, {
        name: "Statistiques",
        url: "/statistics",
    },
    {
        name: "Massages",
        url: "/messaging",
    },
    {
        name: "Consultation",
        url: "/consulting",
    },
    {
        name: "Grand Chantiers",
        url: "/sites",
    },
    {
        name: "Facture",
        url: "/facture",
    },
    {
        name: "Rôles & Permissions",
        url: "/admin/Permission",
    },
    {
        name: "Employées",
        url: "/admin/employees",
    },
    {
        name: "Honoraires",
        children: [
            {
                name: "Dossiers techniques",
                url: "/FolderTechFees",
            },
            {
                name: "Affaires",
                url: "/BusinessFees",
            }
        ],
    },
    {
        name: "Gestions des Affaires",
        children: [
            {
                name: "Natures des affaires",
                url: "/business/natures",
            },
            {
                name: "affaires",
                url: "/business/business",
            },
            {
                name: "Situation des affaires",
                url: "/business/situations",
            },
        ],
    },
    {
        name: "Gestions Relation client",
        children: [
            {
                name: "client",
                url: "/customerRelationship/client",
            },
            {
                name: "intermédiaire",
                url: "/customerRelationship/intermediate",
            },
        ],
    },
    {
        name: "Gestions des Dossier Technique",
        children: [
            {
                name: "Natures des Dossier Technique",
                url: "/folderTech/natures",
            },
            {
                name: "Dossier Technique",
                url: "/folderTech/folderTech",
            },
            {
                name: "Situation des Dossier Technique",
                url: "/folderTech/situations",
            },
        ],
    }, {
        name: "Gestions des Charges",
        children: [
            {
                name: "Charges",
                url: "/Charges/Charge",
            },
            {
                name: "Type de la charge",
                url: "/Charges/type",
            },
            {
                name: "Etat de Facture",
                url: "/Charges/invoiceStatus",
            },
        ],
    },
    {
        name: "Voire l'historique",
        url: "/log",
    },
];
