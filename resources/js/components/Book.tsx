import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export default class Book extends Component {

  componentDidMount() {
    const url = 'api/books';
    fetch(url, {
      headers: {
        Accept: 'application/json'
      },
      credentials: 'same-origin'
    }).then(response => console.log(response.json()));
  }

  render() {
    return (
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-md-8">
              <div className="card">
                <div className="card-header">Example Component</div>

                <div className="card-body">
                  I'm an example component!
                </div>
              </div>
            </div>
          </div>
        </div>
    );
  }
}

if (document.getElementById('content-books')) {
  ReactDOM.render(<Book/>, document.getElementById('content-books'));
}
