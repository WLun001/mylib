import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {BookData} from './types';

export default class Book extends Component<any, BookData> {

  constructor(props: any) {
    super(props);
    this.state = {data: []}
  }

  componentDidMount() {
    const url = 'api/books';
    fetch(url, {
      headers: {
        Accept: 'application/json'
      },
      credentials: 'same-origin'
    }).then(response => {
      if (!response.ok) {
        throw Error([response.status, response.statusText].join(' '));
      }
      return response.json();
    }).then(json => {
      this.setState(json);
    });
  }

  render() {
    const books = this.state.data;
    let content;
    if (!books) {
      content = (
          <p>Loading data...</p>
      );
    } else if (books.length == 0) {
      content = (
          <p>No books in records</p>
      );
    } else {
      const items = books.map(x =>
          <tr key={x.id}>
            <td>{x.id}</td>
            <td>{x.isbn}</td>
            <td>{x.publisher!.id} | {x.publisher!.name}</td>
            <td>{x.title}</td>
            <td>{x.year}</td>
          </tr>
      );

      content = (
          <div className="table-responsive">
            <table className="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Book Id</th>
                <th>ISBN</th>
                <th>Publisher</th>
                <th>Title</th>
                <th>Year</th>
              </tr>
              </thead>
              <tbody>
              {items}
              </tbody>
            </table>
          </div>
      );
    }

    return (
        <div className="content-wrapper">
          {content}
        </div>
    );
  }
}

if (document.getElementById('content-books')) {
  ReactDOM.render(<Book/>, document.getElementById('content-books'));
}
