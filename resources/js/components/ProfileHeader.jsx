export default function ProfileHeader({}) {
    const appURL = window.REACT_APP.APP_URL;

    return (
        <>
            <section>
                <div className="container">
                    <div className="row">
                        <div className="col-12">
                            <div>
                                <div className="col d-flex justify-content-between align-items-center">
                                    <div>

                                    </div>

                                    <button className="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                                        <i className="bi bi-list fs-4"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}


