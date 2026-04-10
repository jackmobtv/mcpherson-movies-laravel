import {useEffect} from "react";
import Layout from "@src/js/components/Layout.jsx";

export default function movies({moviesJSON,formatsJSON,locationsJSON,search,sort,limit,selectedFormats,selectedLocations,beginPage,endPage,totalPages,totalMovies}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const movies = moviesJSON === undefined ? null : JSON.parse(moviesJSON);
    const formats = formatsJSON === undefined ? null : JSON.parse(formatsJSON);
    const locations = locationsJSON === undefined ? null : JSON.parse(locationsJSON);

    useEffect(() => {
        document.title = "Movies";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container py-4">
                <div className="d-flex justify-content-between align-items-center mb-4">
                    <h2>Movies</h2>
                    <a href={appURL + "/add-movie"} className="btn btn-warning float-right mx-2" role="button">Add Movie</a>
                </div>
                <div className="col d-flex justify-content-between align-items-center">
                    <button className="btn btn-primary d-lg-none mb-2" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                        <i className="bi bi-list fs-4"></i>
                    </button>
                </div>
                <div className="row">
                    <div className="col-lg-9">
                        <div className="table-responsive small">
                            <table className="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Format</th>
                                </tr>
                                </thead>
                                <tbody>
                                {movies.map((movie) => (
                                    <tr key={movie.movie_id}>
                                        <td className="align-middle">
                                            <a href={appURL + "/view-movie?id=" + movie.movie_id}>{movie.title}</a>
                                        </td>
                                        <td className="align-middle">{movie.genre}</td>
                                        <td className="align-middle">{movie.release_year === 0 ? "" : movie.release_year}</td>
                                        <td className="align-middle">{movie.location_name}</td>
                                        <td className="align-middle">{movie.format_name}</td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div className="col-lg-3">
                        <div className="offcanvas-lg offcanvas-end" tabIndex="-1" id="offcanvasSidebar">
                            <div className="offcanvas-header">
                                <h5 className="offcanvas-title" id="offcanvasNavbarLabel">Advanced Filter</h5>
                                <button type="button" className="btn-close" data-bs-dismiss="offcanvas"
                                        data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
                            </div>
                            <div className="offcanvas-body p-3">
                                <form method="GET" action={appURL + "/movies"}>
                                    <div className="card card-body shadow p-4 mb-4">
                                        <h4 className="mb-2">Format</h4>

                                        {formats.map((format) => (
                                            <div className="form-check">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    id={"format-filter-" + format.format_id}
                                                    name="formats[]"
                                                    value={format.format_id}
                                                    defaultChecked={selectedFormats.includes(format.format_id)}
                                                />
                                                <label className="form-check-label"
                                                       htmlFor={"format-filter-" + format.format_id}>{format.format_name}</label>
                                            </div>
                                        ))}
                                    </div>
                                    <div className="card card-body shadow p-4 mb-4">
                                        <h4 className="mb-2">Location</h4>

                                        {locations.map((location) => (
                                            <div className="form-check">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    id={"location-filter-" + location.location_id}
                                                    name="locations[]"
                                                    value={location.location_id}
                                                    defaultChecked={selectedLocations.includes(location.location_id)}
                                                />
                                                <label className="form-check-label"
                                                       htmlFor={"location-filter-" + location.location_id}>{location.location_name}</label>
                                            </div>
                                        ))}
                                    </div>

                                    <div className="card card-body shadow p-4 mb-4">
                                        <h4 className="mb-2">Show</h4>

                                        <select className="form-select js-choice z-index-9" aria-label=".form-select-sm"
                                                id="limit" name="limit" defaultValue={limit}>
                                            <option value="0">All</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="500">500</option>
                                        </select>
                                    </div>

                                    <div className="card card-body shadow p-4 mb-4">
                                        <h4 className="mb-2">Sort</h4>

                                        <select className="form-select js-choice z-index-9" aria-label=".form-select-sm"
                                                id="sort" name="sort" defaultValue={sort}>
                                            <option value="default">Default</option>
                                            <option value="title">Title</option>
                                            <option value="genre">Genre</option>
                                            <option value="year">Year</option>
                                            <option value="location">Location</option>
                                            <option value="format">Format</option>
                                        </select>
                                    </div>

                                    <div className="card card-body shadow p-4 mb-4">
                                        <h4 className="mb-2">Search</h4>

                                        <input type="search" className="form-control" placeholder="Search..." aria-label="Search" name="search" defaultValue={search}/>
                                    </div>
                                    <div className="d-grid text-center m-4">
                                        <button type="submit" className="btn btn-primary">Filter Results</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </Layout>
);
}
