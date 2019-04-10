#include <bits/stdc++.h>
#include <iostream> 

using namespace std;

string zupanija = "";

bool linija_je_skola(char c[]) {
  
  string s(c);
 
  size_t found = s.find("Mišljenje");

  if(found != std::string::npos){
    return true;
  }
  else{
    return false;
  }

}

void linija_je_zup(char c[]){

  string s(c);
 
  size_t found = s.find("Županija:");

  int i;
  if(found != std::string::npos){
    zupanija = "";

    for(i = 11; s[i] != ';'; i++){
      zupanija += s[i];
    }
  }
}

bool CheckWord(char* filename, char* search){

  int offset; 
  string line;
  ifstream Myfile;
  Myfile.open (filename);

  if(Myfile.is_open()){

      while(!Myfile.eof()){

          getline(Myfile,line);
          if ((offset = line.find(search, 0)) != string::npos){
           return true;
          }  

      }

      Myfile.close();

  }  

  return false;
}

int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];
  //int counter = 1;
  int counter = 886;
  
  for(int i = 0; i < 242400; i++){
  	cin.std::istream::getline (s, 1000);

    linija_je_zup(s);

  	if(linija_je_skola(s)){ 
      //cout << counter << ";";
      counter++;
       		
      int j = 0;
      while(s[j] != ';'){
        if(s[j] == '"'){
          j++;
          continue;
        }
        cout << s[j];
        j++;
      }
      cout << ";" << zupanija << endl;
  	}
  }

  return 0;
}