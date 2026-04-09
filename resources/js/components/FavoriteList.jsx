export default function FavoriteList({favoriteList}) {
    const appURL = window.REACT_APP.APP_URL;

    return (
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
                {favoriteList.map((movie) => (
                    <tr>
                        <td className="align-middle"><a
                            href={appURL + "/view-movies?id=" + movie.movie_id}>{movie.title}</a></td>
                        <td className="align-middle">{movie.genre}</td>
                        <td className="align-middle">{movie.release_year === 0 ? "" : movie.release_year}</td>
                        <td className="align-middle">{movie.location_name}</td>
                        <td className="align-middle">{movie.format_name}</td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
}


