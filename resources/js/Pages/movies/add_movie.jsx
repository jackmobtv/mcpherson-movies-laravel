import {useEffect} from "react";
import "@src/css/home.css"
import Layout from "@src/js/components/Layout.jsx";

export default function add_movie({formatsJSON, locationsJSON, errors}) {
    const appURL = window.REACT_APP.APP_URL;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formats = formatsJSON === undefined ? null : JSON.parse(formatsJSON);
    const locations = locationsJSON === undefined ? null : JSON.parse(locationsJSON);

    useEffect(() => {
        document.title = "Add Movie";

        const appDiv = document.getElementById('app');
        if (appDiv) {
            appDiv.removeAttribute('data-page');
        }
    }, []);

    return (
        <Layout>
            <div className="container py-4">
                <div className="d-flex justify-content-between align-items-center mb-4">
                    <h2>Add Movie</h2>
                    <a href={appURL + "/movies"} className="btn btn-outline-primary float-right mx-2" role="button">Movie List</a>
                </div>

                <form className="row g-3" method="POST" action={appURL + "/add-movie"}>
                    <input type="hidden" name="_token" value={csrfToken} />
                    <div className="col-md-12">
                        <label htmlFor="title" className="form-label">Title</label>
                        <input type="text" className="form-control" id="title" name="title"/>
                    </div>
                    <div className="col-md-6">
                        <label htmlFor="genre" className="form-label">Genre</label>
                        <input type="text" className="form-control" id="genre" name="genre"/>
                    </div>
                    <div className="col-md-6">
                        <label htmlFor="sub_genre" className="form-label">Sub-Genre</label>
                        <input type="text" className="form-control" id="sub_genre" name="sub_genre"/>
                    </div>
                    <div className="col-md-4">
                        <label htmlFor="release_year" className="form-label">Year</label>
                        <input type="text" maxLength="4" className="form-control" id="release_year" name="release_year"/>
                    </div>
                    <div className="col-md-4">
                        <label htmlFor="locationId" className="form-label">Location ID</label>
                        <select className="form-select js-choice z-index-9" aria-label=".form-select-sm" id="locationId" name="locationId">
                            {locations.map((location) => (
                                <option key={location.location_id} value={location.location_id}>{location.location_name}</option>
                            ))}
                        </select>
                    </div>
                    <div className="col-md-4">
                        <label htmlFor="formatId" className="form-label">Format ID</label>
                        <select className="form-select js-choice z-index-9" aria-label=".form-select-sm" id="formatId" name="formatId">
                            {formats.map((format) => (
                                <option key={format.format_id} value={format.format_id}>{format.format_name}</option>
                            ))}
                        </select>
                    </div>
                    <div className="col-12">
                        <button className="btn btn-secondary" type="submit">Submit form</button>
                    </div>
                </form>

                <div style={{ color: 'red' }} className="mt-3">{errors.message}</div>
            </div>
        </Layout>
    );
}


