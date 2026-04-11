export default function MoviePagination({beginPage, endPage, totalPages, formats, locations, search, limit, sort, page}) {
    const appURL = window.REACT_APP.APP_URL;
    formats = formats.split(',');
    locations = locations.split(',');
    if(page === undefined) page = 1;

    const generateURL = (targetPage) => {
        const parameters = new URLSearchParams();
        parameters.append('page', targetPage);
        console.log(formats);
        if(formats !== null) formats.forEach((format) => parameters.append('formats[]', format));
        if(locations !== null) locations.forEach((location) => parameters.append('locations[]', location));
        if(search) parameters.append('search', search);
        if(limit) parameters.append('limit', limit);
        if(sort) parameters.append('sort', sort);
        return `${appURL}/movies?${parameters.toString()}`;
    }

    return (
        <>
            {(totalPages > 1) &&
                <nav aria-label="...">
                    <ul className="pagination">
                        {(page !== 1) &&
                            <>
                                <li className="page-item">
                                    <a className="page-link" href={generateURL(1)}>
                                        <i className="bi bi-chevron-double-left"></i>
                                    </a>
                                </li>
                                <li className="page-item">
                                    <a className="page-link" href={generateURL(page - 1)}>
                                        <i className="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            </>
                        }

                        {Array.from({length: endPage - beginPage + 1}, (_, idx) => {
                            const i = beginPage + idx;
                            return (
                                <li key={i} className={`page-item ${page === i ? 'active' : ''}`}>
                                    <a className="page-link" href={generateURL(i)}>{i}</a>
                                </li>
                            )
                        })}

                        {(page < totalPages) &&
                            <>
                                <li className="page-item">
                                    <a className="page-link" href={generateURL(page + 1)}>
                                        <i className="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                                <li className="page-item">
                                    <a className="page-link" href={generateURL(totalPages)}>
                                        <i className="bi bi-chevron-double-right"></i>
                                    </a>
                                </li>
                            </>
                        }
                    </ul>
                </nav>
            }
        </>
    );
}


