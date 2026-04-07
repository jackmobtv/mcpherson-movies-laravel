import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";

export default function view_actor({userJSON, actorJSON, moviesJSON}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const user = userJSON === undefined ? null : JSON.parse(userJSON);
    const actor = actorJSON === undefined ? null : JSON.parse(actorJSON);
    const movies = moviesJSON === undefined ? null : JSON.parse(moviesJSON);

    useEffect(() => {
        document.title = "View Actor";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container py-4">
                <h2>Movies Starring {actor.actor_name}</h2>
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
                                <tr>
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
        </Layout>
    );
}


