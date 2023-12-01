export default (party) => {
    switch (party.trim()) {
        case 'Union Solidarity and Development Party':
            return '#00FF00';
        case 'National League for Democracy':
            return '#FF0000';
        case "Kachin State People's Party":
            return '#8c510a';
        case 'Kayah State Democratic Party ':
            return '#bf812d';
        case 'Zo National Region Development Party':
            return '#dfc27d';
        case 'Mon Unity Party':
            return '#f6e8c3';
        case 'Rakhine State National United Party':
            return '#f5f5f5';
        case 'Shan Nationalities Democratic Party':
            return '#c7eae5';
        case 'Ta-Arng (Palaung) National Party':
            return '#80cdc1';
        case 'Pao National Organization (PNO)':
            return '#35978f';
        case 'WA NATIONAL PARTY':
            return '#01665e';
        case 'Arakan Front Party (AFP)':
            return '#003c30';
        case 'New Democracy Party (Kachin)':
            return '#bc80bd';
        case 'Lisu National Development Party(L.N.D.P)':
            return '#ccebc5';
        default:
            return null;
        case 'Kayin Peoples Party':
            return '#80b1d3';
        case 'Chin National League for Democracy Party':
            return '#fdb462';
        case 'La Hu National Development Party':
            return '#b3de69';
    }
};
