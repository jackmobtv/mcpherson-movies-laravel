import {useEffect} from "react";
import Layout from "@src/js/components/Layout.jsx";

export default function view_movie({movieJSON, userJSON, actorsJSON, poster, plot}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const movie = movieJSON === undefined ? null : JSON.parse(movieJSON);
    const actors = actorsJSON === undefined ? null : JSON.parse(actorsJSON);
    const user = userJSON === undefined ? null : JSON.parse(userJSON);

    useEffect(() => {
        document.title = "View Movie";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <>
            <Layout>
                <div className="container py-4">
                    {(movie == null) ? (
                        <>
                            <h2>View Movie</h2>
                            <p className="lead">Movie Not Found</p>
                        </>
                    ) : (
                        <>
                            <div className="d-flex justify-content-between align-items-center">
                                <h2>View Movie</h2>
                                <input type="hidden" id="movieId" value={movie.movie_id}/>
                                <input type="hidden" id="userId" value={user?.user_id || ''}/>
                                {(user !== null) && (
                                    <a className="btn btn-warning float-right mx-2"
                                       href={appURL + "/update-movie?id=" + movie.movie_id}>Update Movie</a>
                                )}
                            </div>
                            <div className="row mt-4">
                                <div className="col-md-6 offset-md-3">
                                    <div className="d-flex justify-content-between align-items-center mb-2">
                                        {movie.movie_id !== 1 && (
                                            <a className="btn btn-outline-primary nav-button"
                                               href={`${appURL}/view-movie?id=${movie.movie_id - 1}`}
                                               aria-label="Previous Movie">
                                                <i className="bi bi-arrow-left"></i>
                                            </a>
                                        )}

                                        <div className="card mx-3 flex-fill">
                                            <div className="card-header d-flex align-items-center">
                                                {user && (
                                                    <i className="bi bi-star me-2" id="star"></i>
                                                )}
                                                <h4 className="flex-grow-1 text-center mb-0">{movie.title}</h4>
                                            </div>
                                            <div className="card-body">
                                                <img src={poster} alt="poster"
                                                     className="img-fluid mb-3 mx-auto d-block"
                                                     style={{maxWidth: '100%', height: 'auto'}}/>
                                                <ul className="list-group">
                                                    <li className="list-group-item">
                                                        <strong>Genre:</strong> {movie.genre}
                                                    </li>
                                                    <li className="list-group-item">
                                                        <strong>Sub-Genre:</strong> {movie.sub_genre}
                                                    </li>
                                                    <li className="list-group-item">
                                                        <strong>Release
                                                            Year:</strong> {movie.release_year === 0 ? "" : movie.release_year}
                                                    </li>
                                                    <li className="list-group-item">
                                                        <strong>Location Name:</strong> {movie.location_name}
                                                    </li>
                                                    <li className="list-group-item">
                                                        <strong>Format Name:</strong> {movie.format_name}
                                                    </li>
                                                </ul>
                                                <p className="mx-auto mt-3 text-center" style={{maxWidth: '600px'}}>
                                                    {plot}
                                                </p>
                                            </div>
                                        </div>

                                        <a className="btn btn-outline-primary nav-button"
                                           href={`${appURL}/view-movie?id=${movie.movie_id + 1}`}
                                           aria-label="Next Movie">
                                            <i className="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div className="table-responsive small mt-5">
                                <table className="table table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">Actor Name</th>
                                        <th scope="col" className="col-2"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        {actors.map((actor) => (
                                            <tr>
                                                <td className="align-middle"><h5>{actor.actor_name}</h5></td>
                                                <td>
                                                    {(user !== null && (user.privileges === 'Admin' || user.privileges === 'Premium') && user.status === 'active') &&
                                                        <a href={appURL + "/view-actor?id=" + actor.actor_id} className="btn btn-outline-primary">View Movies</a>
                                                    }
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </>
                    )}
                </div>
            </Layout>
        </>
    );
}
