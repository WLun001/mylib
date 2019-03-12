export interface BookType {
  id?: number;
  isbn?: string;
  title?: string;
  year?: number;
  authors?: {
    data: {
      id: number;
      name: string;
    }
  }[];
  publisher?: {
    id: number;
    name: string;
  };
}

export interface BookData {
  data: BookType[];
}
