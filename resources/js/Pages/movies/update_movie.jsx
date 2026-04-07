import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";

export default function update_movie({movieJSON, actorsJSON, formatsJSON, locationsJSON, error}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const movie = movieJSON === undefined ? null : JSON.parse(movieJSON);
    const actors = actorsJSON === undefined ? null : JSON.parse(actorsJSON);
    const formats = formatsJSON === undefined ? null : JSON.parse(formatsJSON);
    const locations = locationsJSON === undefined ? null : JSON.parse(locationsJSON);

    useEffect(() => {
        document.title = "Update Movie";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container py-4">
                {(movie === null) ? (
                    <p className="lead">Movie not found</p>
                ) : (
                    <>
                        <div className="d-flex justify-content-between align-items-center mb-4">
                            <h2>Update Movie</h2>
                            <div className="d-flex justify-content align-items-center float-right">
                                <a className="btn btn-primary mx-2" href={appURL + "/view-movie?id=" + movie.movie_id}>View Movie</a>
                                <form method="POST" action={appURL + "/delete-movie"} onSubmit="return confirm('Are You Sure?');">
                                    <input type="hidden" name="_token" value={csrfToken} />
                                    <input type="hidden" name="id" value={movie.movie_id}/>
                                    <button className="btn btn-danger mx-2" type="submit">Delete Movie</button>
                                </form>
                            </div>
                        </div>
                        <form className="row g-3" method="POST" action={appURL + "/update-movie"}>
                            <div className="col-md-2">
                                <label htmlFor="movie_id" className="form-label">Movie ID</label>
                                <input disabled type="text" className="form-control" id="movie_id"
                                       defaultValue={movie.movie_id}/>
                                <input type="hidden" name="movie_id" value={movie.movie_id}/>
                            </div>
                            <div className="col-md-10">
                                <label htmlFor="title" className="form-label">Title</label>
                                <input type="text" className="form-control" id="title" name="title"
                                       defaultValue={movie.title}/>
                            </div>
                            <div className="col-md-6">
                                <label htmlFor="genre" className="form-label">Genre</label>
                                <input type="text" className="form-control" id="genre" name="genre"
                                       defaultValue={movie.genre}/>
                            </div>
                            <div className="col-md-6">
                                <label htmlFor="sub_genre" className="form-label">Sub-Genre</label>
                                <input type="text" className="form-control" id="sub_genre" name="sub_genre"
                                       defaultValue={movie.sub_genre}/>
                            </div>
                            <div className="col-md-4">
                                <label htmlFor="release_year" className="form-label">Year</label>
                                <input type="number" maxLength="4" className="form-control" id="release_year"
                                       name="release_year" min="1900" max="2100"
                                       defaultValue={movie.release_year === "0" ? "" : movie.release_year}/>
                            </div>
                            <div className="col-md-4">
                                <label htmlFor="locationId" className="form-label">Location</label>
                                <select className="form-select js-choice z-index-9" aria-label=".form-select-sm"
                                        id="locationId" name="locationId" defaultValue={movie.location_id}>
                                    {locations.map((location) => (
                                        <option key={location.location_id} value={location.location_id}>{location.location_name}</option>
                                    ))}
                                </select>
                            </div>
                            <div className="col-md-4">
                                <label htmlFor="formatId" className="form-label">Format</label>
                                <select className="form-select js-choice z-index-9" aria-label=".form-select-sm"
                                        id="formatId" name="formatId" defaultValue={movie.format_id}>
                                    {formats.map((format) => (
                                        <option key={format.format_id} value={format.format_id}>{format.format_name}</option>
                                    ))}
                                </select>
                            </div>
                            <div className="col-12">
                                <button className="btn btn-secondary" type="submit">Update Movie</button>
                            </div>
                            <input type="hidden" name="_token" value={csrfToken} />
                        </form>

                        <div style={{ color: 'red' }}className="mt-3">{error}</div>

                        <button type="button" className="btn btn-warning mt-5 mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Actor</button>

                        <div className="table-responsive small">
                            <table className="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">Actor Name</th>
                                    <th scope="col" className="col-3"></th>
                                </tr>
                                </thead>
                                <tbody>
                                {actors.map((actor) => (
                                    <tr>
                                        <td className="align-middle"><h5>{actor.actor_name}</h5></td>
                                        <td>
                                            <a href={appURL + "/view-actor?id=" + actor.actor_id}
                                               className="btn btn-outline-primary mb-1">View Movies</a>
                                            <form action={appURL + "/delete-movie-actor"} method="POST"
                                                  onSubmit="return confirm('Are You Sure?');">
                                                <input type="hidden" name="_token" value={csrfToken} />
                                                <input type="hidden" value={actor.actor_id} name="actor_id"/>
                                                <input type="hidden" value={movie.movie_id} name="movie_id"/>
                                                <button type="submit" className="btn btn-outline-danger">Delete Actor</button>
                                            </form>
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                    </>
                )}
            </div>

            <div className="modal fade" id="exampleModal" tabIndex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <form action={appURL + "/add-actor"} method="POST">
                            <input type="hidden" name="_token" value={csrfToken} />
                            <div className="modal-header">
                                <h1 className="modal-title fs-5" id="exampleModalLabel">Enter New Actor Name</h1>
                                <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div className="modal-body">
                                <div className="form-floating">
                                    <input type="text" className="form-control" id="name" name="name"/>
                                    <label htmlFor="name">Actor Name</label>
                                    <input type="hidden" name="id" value={movie.movie_id}/>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Close
                                </button>
                                <button type="submit" className="btn btn-primary">Add Actor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
    );
}


