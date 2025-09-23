import {useEffect} from "react";
import Layout from "@src/js/components/Layout.jsx";

export default function view_movie({movieJSON, userJSON, poster, plot}) {
    const appURL = window.REACT_APP.APP_URL;
    const movie = movieJSON === undefined ? null : JSON.parse(movieJSON);
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
                            <div className="d-flex justify-content-between alig-items-center">
                                <h2>View Movie</h2>
                                <input type="hidden" id="movieId" value={movie.movie_id}/>
                                <input type="hidden" id="userId" value={user.user_id}/>
                                {(user !== null) && (
                                    <a className="btn btn-warning float-right mx-2" href={appURL + "/update-movies?id=" + movie.movie_id}>Update Movie</a>
                                )}
                            </div>
                            <div className="row mt-4">
                                <div className="col-md-6 offset-md-3">
                                    <div className="d-flex justify-content-between align-items-center mb-2">
                                        <a className="btn btn-outline-primary nav-button" href={(movie.movie_id != 1) ? (appURL + "/view-movies?id=" + (movie.movie_id + 1)) : ("#")} aria-label="Previous Movie">
                                            <i className="bi bi-arrow-left"></i>
                                        </a>
                                        <div className="card mx-3">
                                            <div className="card-header d-flex align-items-center">
                                                {(user !== null) && (
                                                    <i className="bi bi-star me-2" id="star"></i>
                                                )}
                                                <h4 className="flex-grow-1 text-center mb-0">{movie.title}</h4>
                                            </div>
                                            <div className="card-body">
                                                <img src={poster} alt="poster" className="img-fluid mb-3 mx-auto d-block" style={{ maxWidth: '100%', height: 'auto' }} />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </Layout>
        </>
    );
}
