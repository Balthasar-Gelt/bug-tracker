export default function pagination(data) {
    if (data.linksPerPage <= 0 || !data.links || data.current_page < 1) {
        return;
    }

    let paginationLinks = [];

    let links = data.links;
    let linksPerPage = data.linksPerPage;
    let currentPageIndex = data.current_page - 1;
    let linksPerSide = (data.linksPerPage / 2) | 0;
    let link = null;

    if (currentPageIndex != 0) {
        for (let index = linksPerSide; index > 0; index--) {
            if ((link = links[currentPageIndex - index]) != null) {
                paginationLinks.push(link);
                linksPerPage--;
            }
        }
    }

    paginationLinks.push(links[currentPageIndex]);
    linksPerPage--;

    linksPerSide += (linksPerPage - linksPerSide);

    for (let index = 1; index <= linksPerSide; index++) {
        if ((link = links[currentPageIndex + index]) != null) {
            paginationLinks.push(link);
        }
    }

    return paginationLinks;
}