import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";
import "@src/js/script/update-actor.js"

export default function actors({actorsJSON, userJSON}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const actors = actorsJSON === undefined ? null : JSON.parse(actorsJSON);
    const user = userJSON === undefined ? null : JSON.parse(userJSON);

    useEffect(() => {
        document.title = "Actors";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }

        const script = document.createElement('script');
        script.src = '../resources/js/script/update-actor.js';
        script.async = true;
        document.body.appendChild(script);
    }, []);

    return (
        <Layout>
            <div className="row py-4 m-3">
                {actors.map((actor) => (
                    <div className="col-md-4 mb-4">
                        <div className="card h-100">
                            <div className="card-body text-center">
                                <h2 className="card-title">{actor.actor_name}</h2>
                                <div>
                                    <a href={`${appURL}/view-actor?id=${actor.actor_id}`} className="btn btn-outline-primary">View Movies</a>
                                    {(user != null && user.privileges === 'Admin' && user.status === 'active') &&
                                        <>
                                            <button type="button" className="btn btn-outline-warning open-modal ms-1"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    data-id={actor.actor_id} data-name={actor.actor_name}>Update Actor</button>

                                            <form method="POST" action={appURL + "/delete-actor"}
                                                  onSubmit="return confirm('Are You Sure?');" className="mt-1">
                                                <input type="hidden" name="_token" value={csrfToken} />
                                                <input type="hidden" name="id" value={actor.actor_id}/>
                                                <button type="submit" className="btn btn-outline-danger">Delete Actor</button>
                                            </form>
                                        </>
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            <div className="modal fade" id="exampleModal" tabIndex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <form action={appURL + "/update-actor"} method="POST">
                            <input type="hidden" name="_token" value={csrfToken} />
                            <div className="modal-header">
                                <h1 className="modal-title fs-5" id="exampleModalLabel">Enter New Actor Name</h1>
                                <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div className="modal-body">
                                <div className="form-floating">
                                    <input type="text" className="form-control" id="name" name="name"/>
                                    <label form="name">Actor Name</label>
                                    <input type="hidden" id="id" name="id"/>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" className="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
);
}


